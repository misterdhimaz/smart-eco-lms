<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\VideoModuleController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\SimulationController as AdminSimulationController;
use App\Http\Controllers\Admin\VideoCategoryController;
use App\Http\Controllers\Admin\ClassroomController as AdminClassroomController;

// ----------------------------------------------------
// 1. ROUTE GUEST (LOGIN & REGISTER)
// ----------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/verify-otp', [AuthController::class, 'showVerifyForm'])->name('verify.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.post');

    Route::get('/lupa-sandi', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/lupa-sandi', [AuthController::class, 'sendResetOtp'])->name('password.email');

    Route::get('/lupa-sandi/otp', [AuthController::class, 'showVerifyOtpResetForm'])->name('password.verify_otp');
    Route::post('/lupa-sandi/otp', [AuthController::class, 'verifyOtpReset'])->name('password.verify_otp.post');

    Route::get('/reset-sandi', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-sandi', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ----------------------------------------------------
// 2. ROUTE UMUM (LOGOUT & CHAT AI BERSAMA)
// ----------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // PERBAIKAN: Taruh rute Chat AI disini agar Admin maupun Student bisa mengaksesnya!
    Route::post('/chat-ai', [AdminController::class, 'chatAI'])->name('admin.chatAI');
});


// ----------------------------------------------------
// 3. ROUTE KHUSUS MAHASISWA / STUDENT
// ----------------------------------------------------
Route::middleware(['auth', RoleMiddleware::class . ':student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

        // FITUR UJIAN / EVALUASI
        Route::post('/exam/start/{id}', [ExamController::class, 'startExam'])->name('exam.start');
        Route::get('/exam/{attempt_id}', [ExamController::class, 'showExam'])->name('exam.show');
        Route::post('/exam/{attempt_id}/submit', [ExamController::class, 'submitExam'])->name('exam.submit');
        Route::get('/exam/{attempt_id}/result', [ExamController::class, 'examResult'])->name('exam.result');

        // FITUR AI ADVISOR
        Route::get('/ai-advisor', [StudentController::class, 'aiAdvisor'])->name('advisor');
        Route::post('/ai-advisor/chat', [StudentController::class, 'chatGroq'])->name('advisor.chat');

        // MODUL & MATERI PEMBELAJARAN
        Route::get('/modul', [StudentController::class, 'modul'])->name('modul');
        Route::get('/modul/{id}/read', [StudentController::class, 'readModul'])->name('modul.read');
        Route::get('/simulasi', [StudentController::class, 'simulasiIndex'])->name('simulasi');
        Route::get('/video-pembelajaran', [StudentController::class, 'videoIndex'])->name('video');

        // FITUR LAINNYA
        Route::get('/latihan', [StudentController::class, 'latihan'])->name('latihan');
        Route::get('/progress', [StudentController::class, 'progress'])->name('progress');
        Route::get('/ranks', [StudentController::class, 'ranks'])->name('ranks');
        Route::get('/climate-dashboard', [StudentController::class, 'climateDashboard'])->name('climate');
        Route::get('/carbon-calculator', [StudentController::class, 'carbonCalculator'])->name('carbon');

        // PENCARIAN & PENGATURAN
        Route::get('/search', [StudentController::class, 'search'])->name('search');
        Route::get('/settings', [StudentController::class, 'settings'])->name('settings');
        Route::put('/settings', [StudentController::class, 'updateSettings'])->name('settings.update');

        // FITUR PROYEK & KELAS MAHASISWA
        Route::get('/proyek', [StudentController::class, 'proyek'])->name('proyek');
        Route::post('/proyek/join', [StudentController::class, 'joinClassroom'])->name('proyek.join');
        Route::get('/proyek/{id}', [StudentController::class, 'showClassroom'])->name('proyek.show');

        Route::get('/proyek/assignment/{id}', [App\Http\Controllers\Student\ClassroomController::class, 'showAssignment'])->name('proyek.assignment');
        Route::post('/proyek/assignment/{id}/submit', [App\Http\Controllers\Student\ClassroomController::class, 'submitAssignment'])->name('proyek.submit');

        // Rute untuk Klaim XP
        Route::post('/claim-xp', [\App\Http\Controllers\StudentController::class, 'claimXP'])->name('claim_xp');
        Route::post('/claim-video-xp', [\App\Http\Controllers\StudentController::class, 'claimVideoXP'])->name('claim_video_xp');
        Route::get('/games', [\App\Http\Controllers\StudentController::class, 'games'])->name('games');
        Route::post('/modul/{id}/update-progress', [\App\Http\Controllers\StudentController::class, 'updateModuleProgress'])->name('student.modul.progress');
    });


// ----------------------------------------------------
// 4. ROUTE KHUSUS ADMIN / DOSEN
// ----------------------------------------------------
Route::middleware(['auth', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manajemen Pengguna / Mahasiswa
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.destroy');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');

        // Manajemen Modul Pembelajaran
        Route::get('/modules', [AdminController::class, 'modules'])->name('modules');
        Route::post('/modules', [AdminController::class, 'storeModule'])->name('modules.store');
        Route::put('/modules/{id}', [AdminController::class, 'updateModule'])->name('modules.update');
        Route::delete('/modules/{id}', [AdminController::class, 'deleteModule'])->name('modules.destroy');

        // Manajemen Evaluasi (Kuis & Tugas)
        Route::get('/assessments', [AdminController::class, 'assessments'])->name('assessments');
        Route::post('/assessments', [AdminController::class, 'storeAssessment'])->name('assessments.store');
        Route::put('/assessments/{id}', [AdminController::class, 'updateAssessment'])->name('assessments.update');
        Route::delete('/assessments/{id}', [AdminController::class, 'deleteAssessment'])->name('assessments.destroy');

        // PERBAIKAN: Rute Builder Soal & Generator AI
        Route::get('/assessments/{id}/builder', [AdminController::class, 'assessmentBuilder'])->name('assessments.builder');
        Route::post('/assessments/generate-ai', [AdminController::class, 'generateAI'])->name('assessments.ai');
        Route::post('/assessments/{id}/save-questions', [AdminController::class, 'saveQuestions'])->name('assessments.save_questions');

        // Pengaturan Kuis & Rekap Nilai
        Route::post('/assessments/{id}/settings', [AdminController::class, 'updateAssessmentSettings'])->name('assessments.update_settings');
        Route::get('/assessments/{id}/results', [AdminController::class, 'assessmentResults'])->name('assessments.results');
        Route::post('/assessments/grade-essay/{answerId}', [AdminController::class, 'gradeEssay'])->name('assessments.grade_essay');

        // Resource Routes
        Route::resource('video-modules', VideoModuleController::class);
        Route::resource('simulations', AdminSimulationController::class);
        Route::resource('video-categories', VideoCategoryController::class);

        // CRUD Video di dalam Kategori
        Route::get('video-categories/{category}/videos', [VideoController::class, 'index'])->name('videos.index');
        Route::post('video-categories/{category}/videos', [VideoController::class, 'store'])->name('videos.store');
        Route::put('videos/{video}', [VideoController::class, 'update'])->name('videos.update');
        Route::delete('videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');

        // MANAJEMEN KELAS & PROYEK ADMIN
        Route::get('/classrooms', [AdminClassroomController::class, 'index'])->name('classrooms.index');
        Route::post('/classrooms', [AdminClassroomController::class, 'store'])->name('classrooms.store');
        Route::get('/classrooms/{id}', [AdminClassroomController::class, 'show'])->name('classrooms.show');
        Route::post('/classrooms/{id}/assignment', [AdminClassroomController::class, 'storeAssignment'])->name('classrooms.assignment.store');

        // Rute untuk Tugas/Assignment
        Route::get('/assignments/{id}/submissions', [AdminClassroomController::class, 'showAssignment'])->name('classrooms.assignment.show');
        Route::put('/assignments/{id}/update', [AdminClassroomController::class, 'updateAssignment'])->name('classrooms.assignment.update');
        Route::post('/submissions/{id}/grade', [AdminClassroomController::class, 'gradeSubmission'])->name('classrooms.grade');

        // RUTE LAPORAN MAHASISWA
        Route::get('/laporan', [App\Http\Controllers\AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/laporan/{id}/print', [App\Http\Controllers\AdminReportController::class, 'print'])->name('reports.print');
    });
