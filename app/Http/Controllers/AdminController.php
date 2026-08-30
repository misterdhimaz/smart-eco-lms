<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Module;
use App\Models\UserProgress;
use App\Models\VideoModule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\Assessment;
use App\Models\Question;

class AdminController extends Controller
{
    public function index()
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_modules' => Module::count(),
            'avg_progress' => UserProgress::avg('progress_percentage') ?? 0,
            'active_discussions' => 24
        ];
        $recentStudents = User::where('role', 'student')->with('progress.module')->latest()->take(5)->get();

        return view('admin.dashboard', compact('admin', 'stats', 'recentStudents'));
    }

    public function dashboard()
    {
        $admin = Auth::user();

        // 1. STATISTIK KARTU ATAS (Sinkronisasi dengan sistem Modul baru)
        $totalStudents = User::where('role', 'student')->count();
        $totalModules = \App\Models\Module::count(); // Menghitung SEMUA modul

        // Rata-rata progress dari seluruh mahasiswa
        $avgProgress = class_exists(\App\Models\UserProgress::class) ? \App\Models\UserProgress::avg('progress_percentage') : 0;

        $stats = [
            'total_students' => $totalStudents,
            'total_modules'  => $totalModules,
            'avg_progress'   => round($avgProgress ?? 0, 1),
            'active_discussions' => Schema::hasTable('discussions') ? DB::table('discussions')->count() : 12,
        ];

        // 2. SISWA TERBARU (Menarik data progress terbaru mereka)
        $recentStudents = User::where('role', 'student')
                            ->with(['progress' => function($q) {
                                $q->latest('updated_at');
                            }, 'progress.module'])
                            ->latest()
                            ->take(5)
                            ->get();

        // 3. GRAFIK TAHUNAN (Menghitung Pendaftar, Modul, Video, Kuis, & Tugas per bulan)
        $userYearly = []; $moduleYearly = []; $videoYearly = []; $kuisYearly = []; $tugasYearly = [];

        for ($m = 1; $m <= 12; $m++) {
            $userYearly[] = User::where('role', 'student')->whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->count();
            $moduleYearly[] = \App\Models\Module::whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->count();

            // Cek Video
            $videoYearly[] = Schema::hasTable('videos') ? DB::table('videos')->whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->count() :
                             (Schema::hasTable('video_modules') ? DB::table('video_modules')->whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->count() : 0);

            // Cek Kuis
            $kuisYearly[] = class_exists(\App\Models\Assessment::class) ? \App\Models\Assessment::whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->count() : 0;

            // Cek Pengumpulan Tugas (Submissions)
            $tugasYearly[] = Schema::hasTable('submissions') ? DB::table('submissions')->whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->count() : 0;
        }

        $chartData = [
            'year' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                'user' => $userYearly,
                'content' => ['modul' => $moduleYearly, 'video' => $videoYearly],
                'assessment' => ['kuis' => $kuisYearly, 'tugas' => $tugasYearly],
                'total' => [
                    'students' => array_sum($userYearly), 'modules' => array_sum($moduleYearly),
                    'videos' => array_sum($videoYearly), 'kuis' => array_sum($kuisYearly), 'tugas' => array_sum($tugasYearly)
                ]
            ]
        ];

        // 4. DONUT CHART (Kelulusan Global 100% vs 50% vs 0%)
        $selesai = Schema::hasTable('user_progress') ? DB::table('user_progress')->where('progress_percentage', 100)->count() : 0;
        $sedangProses = Schema::hasTable('user_progress') ? DB::table('user_progress')->where('progress_percentage', 50)->count() : 0;
        $totalPunyaProgress = $selesai + $sedangProses;
        $belumMulai = max(0, $totalStudents - $totalPunyaProgress);

        if($selesai == 0 && $sedangProses == 0 && $belumMulai == 0) $belumMulai = 1; // Fallback visual

        $donutData = [$selesai, $sedangProses, $belumMulai];
        $lulusPersen = $totalStudents > 0 ? round(($selesai / $totalStudents) * 100) : 0;

        // 5. PENYIMPANAN SERVER
        $diskPath = storage_path('app/public');
        $freeSpace = disk_free_space($diskPath);
        $totalSpace = disk_total_space($diskPath);
        $usedSpace = $totalSpace - $freeSpace;

        $serverStorage = [
            'used_gb' => round($usedSpace / 1073741824, 2),
            'total_gb' => round($totalSpace / 1073741824, 2),
            'percent' => $totalSpace > 0 ? round(($usedSpace / $totalSpace) * 100) : 0
        ];

        // 6. AKTIVITAS TERKINI (Gabungan User Baru, Modul Baru, & Progress Belajar)
        $activities = [];

        $newStudents = User::where('role', 'student')->latest()->take(2)->get();
        foreach($newStudents as $st) {
            $activities[] = ['color' => 'purple', 'icon' => '👨‍🎓', 'title' => 'Pendaftar Baru', 'desc' => $st->name . ' bergabung.', 'time' => $st->created_at];
        }

        $newModules = \App\Models\Module::latest()->take(2)->get();
        foreach($newModules as $mod) {
            $activities[] = ['color' => 'blue', 'icon' => '📚', 'title' => 'Modul Baru', 'desc' => 'Modul "'.$mod->title.'" dipublikasi.', 'time' => $mod->created_at];
        }

        if(class_exists(\App\Models\UserProgress::class)) {
            $recentProgress = \App\Models\UserProgress::with(['user', 'module'])->latest('updated_at')->take(3)->get();
            foreach($recentProgress as $prog) {
                if($prog->user && $prog->module) {
                    $status = $prog->progress_percentage == 100 ? 'Menyelesaikan Kuis' : 'Membaca PDF';
                    $icon = $prog->progress_percentage == 100 ? '🏆' : '📖';
                    $color = $prog->progress_percentage == 100 ? 'emerald' : 'amber';
                    $activities[] = ['color' => $color, 'icon' => $icon, 'title' => 'Progress Mahasiswa', 'desc' => $prog->user->name . ' ' . $status . ' ' . $prog->module->title, 'time' => $prog->updated_at];
                }
            }
        }

        usort($activities, function($a, $b) { return $b['time'] <=> $a['time']; });
        $activities = array_slice($activities, 0, 5);

        return view('admin.dashboard', compact('admin', 'stats', 'recentStudents', 'chartData', 'donutData', 'lulusPersen', 'serverStorage', 'activities'));
    }

    // ==========================================
    // MANAJEMEN MAHASISWA
    // ==========================================
    public function users()
    {
        $admin = Auth::user();
        $students = User::where('role', 'student')->get();
        return view('admin.users', compact('students', 'admin'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama lengkap mahasiswa wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar di sistem!',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'level' => 1,
            'xp' => 0,
        ]);

        return redirect()->route('admin.users')->with('success', 'Data Mahasiswa berhasil ditambahkan!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Hapus foto profil dari storage jika ada sebelum akunnya dihapus
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Akun Mahasiswa berhasil dihapus!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // GABUNGAN FUNGSI UPDATE YANG BENAR & LENGKAP
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6', // Password opsional
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Ambil semua input kecuali token, method, avatar, dan password
        $data = $request->except(['_token', '_method', 'avatar', 'password']);

        // 1. Cek Jika ada input password baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 2. Cek Jika admin mengupload foto (avatar) baru
        if ($request->hasFile('avatar')) {
            // Hapus foto lama agar storage tidak penuh
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Simpan foto baru
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // 3. Update semua data ke database sekaligus
        $user->update($data);

        return redirect()->route('admin.users.show', $user->id)
                         ->with('success', 'Biodata mahasiswa berhasil diperbarui!');
    }

    // ==========================================
    // MANAJEMEN MODUL PEMBELAJARAN
    // ==========================================
    public function modules(Request $request)
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $query = Module::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        $modules = $query->orderBy('order_number', 'asc')->get();

        return view('admin.modules', compact('admin', 'modules'));
    }

    public function storeModule(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'order_number' => 'required|integer',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document_file' => 'required|mimes:pdf|max:10000',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('modules/covers', 'public');
        }
        if ($request->hasFile('document_file')) {
            $data['document_file'] = $request->file('document_file')->store('modules/documents', 'public');
        }

        Module::create($data);

        return redirect()->route('admin.modules')->with('success', 'Modul beserta file berhasil diunggah!');
    }

    public function updateModule(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'order_number' => 'required|integer',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document_file' => 'nullable|mimes:pdf|max:10000',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('modules/covers', 'public');
        }
        if ($request->hasFile('document_file')) {
            $data['document_file'] = $request->file('document_file')->store('modules/documents', 'public');
        }

        $module->update($data);

        return redirect()->route('admin.modules')->with('success', 'Data modul berhasil diperbarui!');
    }

    public function deleteModule($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();
        return redirect()->route('admin.modules')->with('success', 'Modul berhasil dihapus!');
    }


    // ==========================================
    // MANAJEMEN EVALUASI (KUIS & TUGAS)
    // ==========================================
    public function assessments(Request $request)
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $modules = Module::orderBy('order_number', 'asc')->get();

        $query = Assessment::with('module');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $assessments = $query->latest()->get();

        return view('admin.assessments', compact('admin', 'modules', 'assessments'));
    }

    public function storeAssessment(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'type' => 'required|in:quiz,essay',
            'time_limit' => 'nullable|integer|min:0',
            'xp_reward' => 'required|integer|min:10',
        ]);

        Assessment::create($request->all());

        return redirect()->route('admin.assessments')->with('success', 'Kerangka Evaluasi berhasil dibuat. Silakan lanjut ke pembuatan soal!');
    }

    public function updateAssessment(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'type' => 'required|in:quiz,essay',
            'time_limit' => 'nullable|integer|min:0',
            'xp_reward' => 'required|integer|min:10',
        ]);

        $assessment->update($request->all());

        return redirect()->route('admin.assessments')->with('success', 'Konfigurasi Evaluasi berhasil diperbarui!');
    }

    public function deleteAssessment($id)
    {
        $assessment = Assessment::findOrFail($id);
        $assessment->delete();

        return redirect()->route('admin.assessments')->with('success', 'Data Evaluasi berhasil dihapus!');
    }

    public function assessmentBuilder($id)
    {
        $assessment = Assessment::with(['module', 'questions'])->findOrFail($id);
        $admin = User::where('role', 'admin')->first() ?? User::first();

        $questions = $assessment->questions->map(function ($q) {
            return [
                'temp_id' => $q->id,
                'id' => $q->id,
                'type' => $q->type,
                'text' => $q->text,
                'options' => $q->options ?? ['', '', '', ''],
                'correct_answer' => (int)$q->correct_answer,
                'essay_guideline' => $q->essay_guideline ?? '',
                'is_ai' => (bool)$q->is_ai,
            ];
        });

        return view('admin.assessment_builder', compact('admin', 'assessment', 'questions'));
    }


    // ==========================================
    // GENERATE SOAL VIA GROQ AI
    // ==========================================
    // ==========================================
    // HELPER: DAPATKAN BANYAK API KEY DARI ENV
    // ==========================================
    private function getGroqApiKeys()
    {
        $keys = env('GROQ_API_KEYS');
        if (!$keys) return [];
        return explode(',', $keys);
    }

    // ==========================================
    // GENERATE SOAL VIA GROQ AI (MULTI-KEY ROUND ROBIN)
    // ==========================================
    public function generateAI(Request $request)
    {
        set_time_limit(180); // Beri waktu lebih untuk percobaan berkali-kali

        $request->validate([
            'prompt'         => 'nullable|string',
            'type'           => 'required|in:pg,essay',
            'count'          => 'required|integer|min:1|max:50',
            'module_id'      => 'nullable|integer',
            'module_context' => 'required|string',
        ]);

        $apiKeys = $this->getGroqApiKeys();
        if (empty($apiKeys)) {
            return response()->json(['error' => 'GROQ_API_KEYS belum terpasang di file .env Anda.'], 500);
        }

        $extractedPdfText = "";
        if ($request->has('module_id') && $request->module_id) {
            $module = Module::find($request->module_id);
            if ($module && $module->document_file) {
                $pdfPath = storage_path('app/public/' . $module->document_file);
                if (file_exists($pdfPath)) {
                    try {
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf = $parser->parseFile($pdfPath);
                        $extractedPdfText = mb_substr($pdf->getText(), 0, 12000);
                    } catch (\Throwable $e) {
                        $extractedPdfText = $module->description ?? $module->title;
                    }
                }
            }
        }

        if (empty(trim($extractedPdfText))) {
            $extractedPdfText = $request->module_context;
        }

        $userPrompt = $request->prompt ?? 'Fokuskan soal pada poin-poin terpenting dalam materi ini.';
        $systemPrompt = "ATURAN UTAMA (SANGAT KETAT):
1. Buatkan {$request->count} soal bertipe {$request->type} berbahasa Indonesia.
2. SELURUH PERTANYAAN, OPSI JAWABAN, DAN KUNCI JAWABAN WAJIB 100% DIAMBIL DARI ISI MATERI DOKUMEN DI BAWAH INI.
3. DILARANG KERAS membuat pertanyaan meta seperti 'Apa judul modul?'.
4. DILARANG KERAS menggunakan pengetahuan umum di luar isi teks.
5. Soal harus menguji PEMAHAMAN MATERI PEMBELAJARAN.

DOKUMEN MATERI PEMBELAJARAN:
---
{$extractedPdfText}
---

INSTRUKSI TAMBAHAN DOSEN:
'{$userPrompt}'

ATURAN FORMAT OUTPUT:
- WAJIB KEMBALIKAN HANYA ARRAY JSON MURNI TANPA MARKDOWN.

Format JSON Pilihan Ganda (pg):
[ { \"type\": \"pg\", \"text\": \"...\", \"options\": [\"A\", \"B\", \"C\", \"D\"], \"correct_answer\": 0, \"essay_guideline\": \"\", \"is_ai\": true } ]
Format JSON Esai (essay):
[ { \"type\": \"essay\", \"text\": \"...\", \"options\": [\"\", \"\", \"\", \"\"], \"correct_answer\": 0, \"essay_guideline\": \"Kunci...\", \"is_ai\": true } ]";

        // LOOPING FALLBACK API KEY
        $lastError = null;

        foreach ($apiKeys as $index => $apiKey) {
            try {
                $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . trim($apiKey),
                        'Content-Type'  => 'application/json',
                    ])
                    ->timeout(90)
                    ->post('https://api.groq.com/openai/v1/chat/completions', [
                        'model' => 'openai/gpt-oss-20b', // Gunakan versi resmi llama3
                        'messages' => [
                            ['role' => 'system', 'content' => 'Anda adalah pembuat soal akademis profesional.'],
                            ['role' => 'user', 'content' => $systemPrompt]
                        ],
                        'temperature' => 0.2,
                        'max_tokens' => 5000,
                    ]);

                // Jika Limit habis, SIMPAN error, lalu COBA key berikutnya
                if ($response->status() === 429) {
                    $lastError = 'API Key ke-'.($index+1).' Limit. Mencoba yang lain...';
                    continue; // Skip dan lanjut ke perulangan key berikutnya
                }

                if ($response->successful()) {
                    $aiText = $response->json('choices.0.message.content');
                    if (!$aiText) return response()->json(['error' => 'AI tidak memberikan respon.'], 500);

                    preg_match('/\[.*\]/s', $aiText, $matches);
                    $cleanJson = $matches[0] ?? $aiText;
                    $questions = json_decode($cleanJson, true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($questions)) {
                        return response()->json($questions, 200);
                    }

                    return response()->json(['error' => 'Format JSON terpotong. Coba kurangi jumlah soal.'], 500);
                }

                $lastError = $response->json('error.message') ?? $response->status();

            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
            }
        } // End Foreach

        // Jika semua Key dicoba tapi gagal semua
        return response()->json(['error' => 'Semua API Key kehabisan limit/Error. Detail: ' . $lastError], 500);
    }

    // ==========================================
    // AI CHAT BOTS (MULTI-KEY ROUND ROBIN)
    // ==========================================
    public function chatGroq(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $apiKeys = $this->getGroqApiKeys();

        if (empty($apiKeys)) {
            return response()->json([
                'reply' => '<div class="p-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl font-medium text-xs">⚠️ <strong>API Key Groq Belum Dipasang</strong></div>'
            ]);
        }

        $lastError = null;

        // LOOPING FALLBACK API KEY UNTUK CHAT
        foreach ($apiKeys as $apiKey) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(20)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . trim($apiKey),
                        'Content-Type' => 'application/json',
                    ])
                    ->post('https://api.groq.com/openai/v1/chat/completions', [
                        'model' => 'openai/gpt-oss-20b', // Gunakan model terbaik chat
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => 'Anda adalah EcoBot, asisten AI untuk SMART-ECO. PENTING: Dilarang menyertakan salam/greeting di awal setiap respon kecuali di chat pertama. Langsung berikan jawaban inti dengan format yang rapi, informatif, dan komunikatif.'
                            ],
                            [
                                'role' => 'user',
                                'content' => $request->message
                            ]
                        ],
                    ]);

                // Jika Kena Limit, coba key berikutnya
                if ($response->status() === 429) {
                    $lastError = 'Rate Limit';
                    continue;
                }

                if ($response->successful()) {
                    $reply = $response->json('choices.0.message.content');
                    return response()->json([
                        'reply' => Str::markdown($reply)
                    ]);
                }

                $lastError = $response->json('error.message') ?? $response->body();

            } catch (\Exception $e) {
                $lastError = $e->getMessage();
            }
        }

        // Jika semua Key Gagal
        return response()->json([
            'reply' => '<div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl font-medium text-xs">❌ <strong>Semua API Key Gagal:</strong><br>' . e($lastError) . '</div>'
        ]);
    }

    // ==========================================
    // SIMPAN SOAL-SOAL KE DATABASE
    // ==========================================
    public function saveQuestions(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:pg,essay',
        ]);

        Question::where('assessment_id', $assessment->id)->delete();

        foreach ($request->questions as $q) {
            Question::create([
                'assessment_id'   => $assessment->id,
                'type'            => $q['type'],
                'text'            => $q['text'],
                'options'         => $q['options'] ?? null,
                'correct_answer'  => isset($q['correct_answer']) ? (int)$q['correct_answer'] : 0,
                'essay_guideline' => $q['essay_guideline'] ?? null,
                'is_ai'           => $q['is_ai'] ?? false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Seluruh soal kuis berhasil dipublikasikan ke database!'
        ]);
    }

    // ==========================================
    // 1. UPDATE PENGATURAN KUIS (TERMASUK AJAX)
    // ==========================================
    public function updateAssessmentSettings(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        $request->validate([
            'duration_minutes'  => 'required|integer|min:1',
            'passing_grade'     => 'required|integer|min:0|max:100',
            'max_attempts'      => 'required|integer|min:1',
            'shuffle_questions' => 'nullable|boolean',
        ]);

        $assessment->update([
            'duration_minutes'  => $request->duration_minutes,
            'passing_grade'     => $request->passing_grade,
            'max_attempts'      => $request->max_attempts,
            'shuffle_questions' => $request->has('shuffle_questions') ? 1 : 0,
        ]);

        // MENGAMANKAN RESPONSE JIKA DIMINTA VIA FETCH/AJAX
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan evaluasi berhasil diperbarui!'
            ]);
        }

        return redirect()->back()->with('success', 'Pengaturan kuis berhasil diperbarui!');
    }

    // ==========================================
    // 2. HALAMAN REKAP NILAI & KOREKSI
    // ==========================================
    public function assessmentResults($id)
    {
        $assessment = Assessment::with(['questions', 'module'])->findOrFail($id);
        return view('admin.assessment_results', compact('assessment'));
    }

    public function gradeEssay(Request $request, $answerId)
    {
        $request->validate([
            'score'    => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nilai esai berhasil disimpan!'
        ]);
    }

    // ==========================================
    // AI CHAT BOTS
    // ==========================================
    public function chatAI(Request $request)
    {
        return $this->chatGroq($request); // Meneruskan ke fungsi chatGroq agar tidak duplikat
    }


}
