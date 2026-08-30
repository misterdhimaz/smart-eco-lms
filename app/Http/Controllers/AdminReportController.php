<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminReportController extends Controller
{
    // 1. Menampilkan Daftar Mahasiswa & Filter
    public function index(Request $request)
    {
        // Ganti 'student' dengan role mahasiswa Anda jika berbeda (misal: 'user' atau 'mahasiswa')
        $query = User::where('role', 'student');

        // Filter Pencarian Nama/Email
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Kode Kelas
        if ($request->filled('kode_kelas')) {
            $query->where('kode_kelas', $request->kode_kelas);
        }

        // Filter Jenis Kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $students = $query->orderBy('name', 'asc')->paginate(15);

        // Ambil daftar kelas unik untuk dropdown filter
        $kelasList = User::whereNotNull('kode_kelas')->distinct()->pluck('kode_kelas');

        return view('admin.laporan.index', compact('students', 'kelasList'));
    }

    // 2. Menampilkan Rapor untuk Dicetak
    public function print($id)
    {
        // Jika nama relasi Anda berbeda, sesuaikan 'userProgresses' dan 'examAttempts'
        $student = User::with(['userProgresses.module', 'examAttempts.assessment'])->findOrFail($id);

        return view('admin.laporan.print', compact('student'));
    }
}
