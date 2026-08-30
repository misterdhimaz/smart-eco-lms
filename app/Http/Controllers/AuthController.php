<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // ==========================================
    // LOGIN
    // ==========================================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();

            // Cek apakah email sudah diverifikasi via OTP
            if (is_null($user->email_verified_at) && $user->role == 'student') {
                Auth::logout();
                return redirect()->route('verify.otp', ['email' => $user->email])
                                 ->with('error', 'Akun Anda belum diverifikasi. Silakan masukkan kode OTP yang dikirim ke email Anda.');
            }

            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->route('admin.assessments')->with('success', 'Selamat datang kembali, Admin!');
            }
            return redirect()->route('student.dashboard')->with('success', 'Selamat datang!');
        }

        return back()->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])->onlyInput('email');
    }

    // ==========================================
    // REGISTER
    // ==========================================
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ==========================================
    // REGISTER
    // ==========================================
   public function register(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:50',
            // UBAH BARIS INI: Pastikan hanya "required|string"
            'jenis_kelamin'  => 'required|string',
            'kode_kelas'     => 'required|string|exists:classrooms,code',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:8|confirmed',
        ], [
            'kode_kelas.exists' => 'Kode Kelas tidak valid atau tidak ditemukan. Tanyakan pada dosen Anda!'
        ]);

        // 1. Buat Kode OTP 6 Digit
        $otp = rand(100000, 999999);

        // 2. Buat user dengan status belum terverifikasi
        $user = User::create([
            'name'           => $request->name,
            'nama_panggilan' => $request->nama_panggilan,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'kode_kelas'     => $request->kode_kelas,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => 'student',
            'otp_code'       => $otp,
        ]);

        // 3. Otomatis Gabungkan Mahasiswa ke dalam Kelas (Tabel classroom_user)
        $classroom = \Illuminate\Support\Facades\DB::table('classrooms')
                        ->where('code', $request->kode_kelas)
                        ->first();

        if ($classroom) {
            \Illuminate\Support\Facades\DB::table('classroom_user')->insert([
                'classroom_id' => $classroom->id,
                'user_id'      => $user->id,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // 4. Kirim Email OTP Menggunakan Queue (Instan di Latar Belakang)
        \App\Jobs\SendOtpEmailJob::dispatch($user->email, $user->nama_panggilan, $otp, 'Kode Verifikasi Akun SMART-ECO');

        // 5. Redirect ke halaman verifikasi OTP
        return redirect()->route('verify.otp', ['email' => $user->email])
                         ->with('success', 'Pendaftaran berhasil! Kode verifikasi telah dikirim ke email Anda.');
    }

    // ==========================================
    // VERIFIKASI OTP
    // ==========================================
    public function showVerifyForm(Request $request)
    {
        return view('auth.verify', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric'
        ]);

        $user = User::where('email', $request->email)->where('otp_code', $request->otp)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->otp_code = null; // Hapus OTP setelah berhasil
            $user->save();

            return redirect()->route('login')->with('success', 'Akun berhasil diverifikasi! Silakan login.');
        }

        return back()->with('error', 'Kode OTP salah atau tidak valid.');
    }

    // ==========================================
    // LOGOUT
    // ==========================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar dari akun.');
    }

    // ==========================================
    // TAHAP 1: LUPA PASSWORD (KIRIM OTP)
    // ==========================================
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email'], [
            'email.exists' => 'Email ini belum terdaftar di sistem kami.'
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(2);
        $user->save();

        // Kirim Email OTP Menggunakan Queue (Instan di Latar Belakang)
        \App\Jobs\SendOtpEmailJob::dispatch($user->email, $user->nama_panggilan, $otp, 'Reset Sandi SMART-ECO');

        // Arahkan ke Tahap 2 (Verifikasi OTP)
        return redirect()->route('password.verify_otp', ['email' => $user->email])
                         ->with('success', 'Kode OTP telah dikirim. Segera cek email Anda! (Berlaku 2 Menit)');
    }

    // ==========================================
    // TAHAP 2: VERIFIKASI OTP RESET SANDI
    // ==========================================
    public function showVerifyOtpResetForm(Request $request)
    {
        if (!$request->email) return redirect()->route('password.request');
        return view('auth.verify-otp-reset', ['email' => $request->email]);
    }

    public function verifyOtpReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required|numeric'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->otp_code != $request->otp) {
            return back()->with('error', 'Kode OTP tidak valid atau salah.');
        }

        if (now()->greaterThan(\Carbon\Carbon::parse($user->otp_expires_at))) {
            return back()->with('error', 'Kode OTP sudah KADALUARSA! Silakan minta kode baru.');
        }

        // OTP Benar! Arahkan ke Tahap 3 (Buat Sandi Baru) sambil membawa email & OTP
        return redirect()->route('password.reset', ['email' => $user->email, 'otp' => $request->otp])
                         ->with('success', 'OTP valid! Silakan buat kata sandi baru Anda.');
    }

    // ==========================================
    // TAHAP 3: BUAT SANDI BARU
    // ==========================================
    public function showResetPasswordForm(Request $request)
    {
        // Tolak akses jika tidak ada email dan otp dari tahap sebelumnya
        if (!$request->email || !$request->otp) {
            return redirect()->route('password.request')->with('error', 'Akses tidak sah. Silakan ulangi proses dari awal.');
        }
        return view('auth.reset-password', ['email' => $request->email, 'otp' => $request->otp]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'otp'      => 'required|numeric',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        // Validasi ulang OTP untuk memastikan keamanan lapis dua
        if ($user->otp_code != $request->otp || now()->greaterThan(\Carbon\Carbon::parse($user->otp_expires_at))) {
            return redirect()->route('password.request')->with('error', 'Sesi OTP tidak valid atau sudah kedaluwarsa. Silakan ulangi.');
        }

        // Simpan sandi baru
        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui! Silakan masuk dengan sandi baru Anda.');
    }


}
