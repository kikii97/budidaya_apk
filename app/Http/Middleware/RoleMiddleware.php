<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Cek setiap guard yang tersedia
        $guards = ['admin', 'pembudidaya', 'web'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Jika role-nya sesuai
                if ($user->role === $role) {
                    return $next($request);
                }

                // Jika user login tapi tidak sesuai role
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        // Tidak ada user yang login
        return redirect()->route('login')->withErrors(['message' => 'Silakan login terlebih dahulu.']);
    }
}

