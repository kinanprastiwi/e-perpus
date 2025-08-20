<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PetugasMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'petugas'])) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Akses ditolak. Hanya Petugas yang dapat mengakses halaman ini.');
    }
}