<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($guard === 'pembudidaya') {
                    return redirect()->route('pembudidaya.detail_usaha'); // Ubah ke rute yang sesuai
                } elseif ($guard === 'web') {
                    return redirect()->route('home'); // Arahkan user ke home
                }
            }
        }

        return $next($request);
    }
}