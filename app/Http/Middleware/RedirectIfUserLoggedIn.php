<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfUserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session 'user' ada
        if ($request->session()->has('user')) {
            // Kalau sudah login, redirect ke dashboard
            return redirect()->route('dashboard');
        }

        // Kalau belum login, lanjutkan request
        return $next($request);
    }
}
