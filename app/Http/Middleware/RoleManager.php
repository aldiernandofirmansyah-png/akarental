<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('landing');
        }

        if (Auth::user()->role !== $role) {
            // Jika role tidak sesuai, arahkan ke dashboard masing-masing atau landing
            return auth()->user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('pelanggan.dashboard');
        }

        return $next($request);
    }
}
