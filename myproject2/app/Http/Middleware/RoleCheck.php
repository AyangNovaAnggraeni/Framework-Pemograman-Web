<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // cek apakah user sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // cek apakah role user termasuk dalam roles yang diizinkan
            if (in_array($user->role, $roles)) {
                return $next($request);
            }

            // kalau login tapi role tidak cocok
            abort(403, 'Unauthorized.');
        }

        // kalau belum login, redirect ke login
        return redirect()->route('login')->with('error', 'Please login first.');
    }
}
