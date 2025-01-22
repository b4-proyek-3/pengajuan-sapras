<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckReviewerRole
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sedang login
        if (auth()->check()) {
            // Ambil data reviewer berdasarkan id_user
            $reviewer = auth()->user()->reviewer;

            // Jika reviewer ditemukan dan role-nya adalah 'wd-3'
            if ($reviewer && $reviewer->role === 'wd-3') {
                return $next($request); // Lanjutkan ke request
            }
        }

        // Jika tidak, arahkan ke halaman yang diinginkan (misalnya home)
        return redirect('/dashboard')->with('error', 'You do not have access to this page.');
    }
}
