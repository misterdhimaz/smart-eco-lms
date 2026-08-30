<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    // Daftar Kelas yang Diikuti Mahasiswa
    public function index()
    {
        $user = Auth::user();
        $classrooms = $user->classrooms()->with('admin')->get();
        return view('student.proyek.index', compact('classrooms'));
    }

    // Join Kelas Menggunakan Kode 5 Digit
    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:5',
        ]);

        $code = strtoupper(trim($request->code));
        $classroom = Classroom::where('code', $code)->first();

        if (!$classroom) {
            return redirect()->back()->with('error', 'Kode kelas tidak ditemukan! Periksa kembali 5 digit kode Anda.');
        }

        $user = Auth::user();

        // Cek jika sudah bergabung
        if ($user->classrooms()->where('classroom_id', $classroom->id)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah bergabung di kelas ini!');
        }

        $user->classrooms()->attach($classroom->id);

        return redirect()->route('student.proyek.show', $classroom->id)->with('success', 'Berhasil bergabung di kelas ' . $classroom->name);
    }

    // Halaman Detail Kelas Mahasiswa
    public function show($id)
    {
        $classroom = Classroom::with(['assignments' => function($q) {
            $q->latest();
        }, 'admin'])->findOrFail($id);

        return view('student.proyek.show', compact('classroom'));
    }

    // Halaman Detail Tugas & Upload Pengumpulan
    public function showAssignment($id)
    {
        $assignment = Assignment::with('classroom')->findOrFail($id);
        $submission = Submission::where('assignment_id', $id)
                                ->where('user_id', Auth::id())
                                ->first();

        return view('student.proyek.assignment_detail', compact('assignment', 'submission'));
    }

    // Kirim / Upload Hasil Tugas & Komentar Pribadi
    public function submitAssignment(Request $request, $assignmentId)
    {
        $request->validate([
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,zip,rar,jpg,png|max:10240',
            'student_comment' => 'nullable|string',
        ]);

        $submission = Submission::firstOrNew([
            'assignment_id' => $assignmentId,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('file_path')) {
            $submission->file_path = $request->file('file_path')->store('submissions/files', 'public');
        }

        $submission->student_comment = $request->student_comment;
        $submission->status = 'submitted';
        $submission->save();

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
