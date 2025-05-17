<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect sesuai guard
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($guard === 'pembudidaya') {
                    return redirect()->route('pembudidaya.profil');
                } else {
                    return redirect()->route('profile.index');
                }
            }
        } else {
            if (Auth::check()) {
                return redirect()->route('profile.index');
            }
        }

        return $next($request);
    }
}
