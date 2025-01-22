<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPengaju
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sedang login
        if (auth()->check()) {
            // Cek apakah user memiliki pengaju
            $pengaju = auth()->user()->pengaju;

            // Jika user memiliki pengaju (relasi user dengan pengaju ada)
            if ($pengaju) {
                return $next($request); // Lanjutkan ke request
            }
        }

        // Jika tidak memiliki pengaju, arahkan ke halaman yang diinginkan (misalnya home)
        return redirect('/dashboard')->with('error', 'You do not have access to this page.');
    }
}