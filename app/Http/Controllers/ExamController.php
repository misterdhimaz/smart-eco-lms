<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\StudentAttempt;
use App\Models\StudentAnswer;
use App\Models\UserProgress;

class ExamController extends Controller
{
    // 1. MULAI UJIAN (POST)
    // 1. MULAI UJIAN (POST)
    public function startExam($assessmentId)
    {
        $user = Auth::user();
        $assessment = Assessment::findOrFail($assessmentId);

        // A. Cek apakah ada pengerjaan yang MASIH BERLANGSUNG (Belum Selesai)
        $activeAttempt = StudentAttempt::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->where('is_completed', false)
            ->first();

        // Jika ada attempt yang belum selesai, langsung arahkan ke lembar ujian tersebut!
        if ($activeAttempt) {
            return redirect()->route('student.exam.show', $activeAttempt->id);
        }

        // B. Cek jumlah percobaan yang sudah SELESAI
        $completedAttempts = StudentAttempt::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->where('is_completed', true)
            ->count();

        // Tentukan nilai max_attempts (default minimal 3 kali jika di DB kosong/0)
        $maxAllowed = $assessment->max_attempts ?: 3;

        if ($completedAttempts >= $maxAllowed) {
            return redirect()->route('student.dashboard')->with('error', 'Anda telah mencapai batas maksimal percobaan (' . $maxAllowed . 'x) untuk kuis ini.');
        }

        // C. Buat Sesi Attempt Baru
        $attempt = StudentAttempt::create([
            'user_id' => $user->id,
            'assessment_id' => $assessment->id,
            'attempt_number' => $completedAttempts + 1,
            'total_score' => 0,
            'is_completed' => false,
            'is_passed' => false,
            'started_at' => now(),
        ]);

        return redirect()->route('student.exam.show', $attempt->id);
    }

    // 2. TAMPILKAN SOAL UJIAN (GET)
    public function showExam($attemptId)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $attempt = \App\Models\StudentAttempt::with('assessment')
            ->where('user_id', $user->id)
            ->findOrFail($attemptId);

        if ($attempt->is_completed) {
            return redirect()->route('student.exam.result', $attempt->id)
                             ->with('info', 'Anda sudah menyelesaikan evaluasi ini.');
        }

        $assessment = $attempt->assessment;

        $questions = \App\Models\Question::where('assessment_id', $assessment->id)->get()->map(function ($q) {

            $optionsData = is_array($q->options)
                ? $q->options
                : json_decode($q->options ?? '[]', true);

            return [
                'id' => $q->id,
                'type' => $q->type,
                // TRIK AMAN: Cari teks soal di berbagai kemungkinan nama kolom database Anda!
                'text' => $q->question_text ?? $q->question ?? $q->text ?? $q->content ?? '<i class="text-rose-500">Teks soal kosong di database.</i>',
                'options' => is_array($optionsData) ? array_values($optionsData) : [],
            ];
        });

        return view('student.exam', compact('assessment', 'attempt', 'questions'));
    }


    // 3. KIRIM & HITUNG JAWABAN (POST API/AJAX)
   // 3. KIRIM & HITUNG JAWABAN (POST API/AJAX)
    public function submitExam(Request $request, $attempt_id)
    {
        try {
            $user = Auth::user();
            $attempt = StudentAttempt::with('assessment')->findOrFail($attempt_id);
            $assessment = $attempt->assessment;

            // 1. KOREKSI JAWABAN (Contoh untuk soal Pilihan Ganda)
            $answers = $request->answers ?? [];
            $correctCount = 0;
            $questions = Question::where('assessment_id', $assessment->id)->get();
            $totalQuestions = $questions->count();

            if ($totalQuestions > 0) {
                foreach ($questions as $q) {
                    if ($q->type == 'pg' && isset($answers[$q->id])) {
                        if ($answers[$q->id] == $q->correct_answer) {
                            $correctCount++;
                        }
                    }
                }
                $score = round(($correctCount / $totalQuestions) * 100);
            } else {
                $score = 0;
            }

            // 2. CEK KELULUSAN (KKM / Passing Grade)
            $passingGrade = $assessment->passing_grade ?? 70; // Fallback aman
            $isPassed = $score >= $passingGrade;

            // 3. SIMPAN HASIL KE DATABASE
            $attempt->total_score = $score;
            $attempt->is_passed = $isPassed;
            $attempt->is_completed = true;
            $attempt->save();

            $xpGained = 0;
            $levelUp = false;
            $newLevel = $user->level ?? 1;

            // 4. JIKA LULUS: BERIKAN XP & CATAT RIWAYAT
            if ($isPassed) {

                // A. Update Progress Modul jadi 100%
                if ($assessment->module_id && class_exists(\App\Models\UserProgress::class)) {
                    $progress = \App\Models\UserProgress::firstOrCreate(
                        ['user_id' => $user->id, 'module_id' => $assessment->module_id],
                        ['progress_percentage' => 0]
                    );
                    $progress->progress_percentage = 100;
                    $progress->save();
                }

                // B. Tambahkan XP (Aman dari nilai null)
                $xpGained = (int) ($assessment->xp_reward ?? 50);
                $user->xp = ($user->xp ?? 0) + $xpGained;

                // C. Cek Kenaikan Level
                if ($user->xp >= ($user->level * 1000)) {
                    $user->level += 1;
                    $newLevel = $user->level;
                    $levelUp = true;
                }
                $user->save();

                // D. CATAT KE BUKU RIWAYAT (Aman dari class not found)
                if (class_exists(\App\Models\XpLog::class)) {
                    \App\Models\XpLog::create([
                        'user_id' => $user->id,
                        'type' => 'latihan',
                        'title' => 'Misi Evaluasi: ' . ($assessment->title ?? 'Kuis'),
                        'xp' => $xpGained
                    ]);
                }
            }

            // 5. KEMBALIKAN RESPON KE LAYAR MAHASISWA
            return response()->json([
                'success' => true,
                'is_passed' => $isPassed,
                'score' => $score,
                'xp_gained' => $xpGained,
                'level_up' => $levelUp,
                'new_level' => $newLevel,
                'redirect_url' => route('student.exam.result', $attempt->id),
                'message' => $isPassed ? 'Hebat!' : 'Jangan menyerah!'
            ]);

        } catch (\Exception $e) {
            // 🚨 PENANGKAP ERROR OTOMATIS:
            // Jika gagal, pop-up akan menampilkan pesan error aslinya dari Laravel
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage() . ' (Baris ' . $e->getLine() . ')'
            ], 500);
        }
    }

    // 4. HASIL UJIAN & SCOREBOARD (GET)
    public function examResult($attemptId)
    {
        $user = Auth::user();
        $attempt = StudentAttempt::with('assessment')->where('user_id', $user->id)->findOrFail($attemptId);

        return view('student.exam_result', compact('attempt'));
    }
}
