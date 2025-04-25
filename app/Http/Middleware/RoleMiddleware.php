<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Check if the user is logged in and which guard they are using
        $user = Auth::user(); // This assumes you're using 'web' guard by default
        
        if ($user) {
            // If the user's role doesn't match the required role, deny access
            if ($user->role !== $role) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }

            // Proceed with the request if the role matches
            return $next($request);
        }

        // If no user is logged in, return a 403 response (for all guards)
        abort(403, 'Silakan login terlebih dahulu.');
    }
}
