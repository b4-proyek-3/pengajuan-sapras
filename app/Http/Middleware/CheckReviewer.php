<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckReviewer
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sedang login
        if (auth()->check()) {
            // Cek apakah user memiliki reviewer
            $reviewer = auth()->user()->reviewer;

            // Jika user memiliki reviewer (relasi user dengan reviewer ada)
            if ($reviewer) {
                return $next($request); // Lanjutkan ke request
            }
        }

        // Jika tidak memiliki reviewer, arahkan ke halaman yang diinginkan (misalnya home)
        return redirect('/dashboard')->with('error', 'You do not have access to this page.');
    }
}
