<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role !== $role) {
            // Jika role tidak sesuai, kembalikan sesuai role asli user
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.assessments')->with('error', 'Akses ditolak.');
            }
            return redirect()->route('student.dashboard')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
