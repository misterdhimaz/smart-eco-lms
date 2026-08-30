<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    // Daftar Kelas buatan Admin
    public function index()
    {
        $classrooms = Classroom::where('admin_id', Auth::id())->withCount(['students', 'assignments'])->latest()->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    // Buat Kelas Baru (Generate Kode 5 Digit Unik)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Generate 5 digit kode alfanumerik kapital unik
        do {
            $code = strtoupper(Str::random(5));
        } while (Classroom::where('code', $code)->exists());

        Classroom::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'description' => $request->description,
            'code' => $code,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil dibuat dengan Kode Akses: ' . $code);
    }

    // Detail Kelas Admin (Daftar Tugas & Mahasiswa)
    public function show($id)
    {
        $classroom = Classroom::with(['assignments' => function($q) {
            $q->latest();
        }, 'students'])->findOrFail($id);

        return view('admin.classrooms.show', compact('classroom'));
    }

    // Admin Buat Tugas / Proyek Baru untuk Kelas Ini
    public function storeAssignment(Request $request, $classroomId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,png|max:10240',
            'due_date' => 'nullable|date',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('assignments/attachments', 'public');
        }

        Assignment::create([
            'classroom_id' => $classroomId,
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $attachmentPath,
            'due_date' => $request->due_date,
        ]);

        return redirect()->back()->with('success', 'Proyek/Tugas baru berhasil dipublikasikan!');
    }

    // Halaman Admin Melihat Pengumpulan Tugas Mahasiswa & Memberi Nilai
    public function showAssignment($id)
    {
        $assignment = Assignment::with(['classroom', 'submissions.student'])->findOrFail($id);
        return view('admin.classrooms.assignment_detail', compact('assignment'));
    }

    // Admin Input Nilai & Feedback
    public function gradeSubmission(Request $request, $submissionId)
    {
        $request->validate([
            'grade' => 'required|integer|min:0|max:100',
            'admin_feedback' => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($submissionId);
        $submission->update([
            'grade' => $request->grade,
            'admin_feedback' => $request->admin_feedback,
            'status' => 'graded'
        ]);

        return redirect()->back()->with('success', 'Nilai dan umpan balik berhasil disimpan!');
    }


    public function updateAssignment(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,png|max:10240',
        'due_date' => 'nullable|date',
    ]);

    $assignment = Assignment::findOrFail($id);

    if ($request->hasFile('attachment')) {
        // Hapus file lama jika ada
        if ($assignment->attachment) {
            Storage::disk('public')->delete($assignment->attachment);
        }
        $assignment->attachment = $request->file('attachment')->store('assignments/attachments', 'public');
    }

    $assignment->update([
        'title' => $request->title,
        'description' => $request->description,
        'due_date' => $request->due_date,
    ]);

    return redirect()->back()->with('success', 'Tugas "' . $assignment->title . '" berhasil diperbarui!');
}


}
