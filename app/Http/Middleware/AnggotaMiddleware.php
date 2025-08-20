<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AnggotaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'anggota') {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Akses ditolak. Hanya Anggota yang dapat mengakses halaman ini.');
    }
}