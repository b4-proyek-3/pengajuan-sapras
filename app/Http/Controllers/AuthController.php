<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaju;
use App\Models\Reviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('pengajuan.index');
        }
        return view('pages.Auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@polban\.ac\.id$/',
            ],
            'password' => 'required|min:6',
        ], [
            'email.regex' => 'Gunakan email polban!',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Dapatkan user yang login
            $user = Auth::user();

            // Cek apakah user adalah pengaju atau reviewer
            if (Pengaju::where('id_user', $user->id_user)->exists()) {
                return redirect()->intended('/pengajuan');
            } elseif (Reviewer::where('id_user', $user->id_user)->exists()) {
                return redirect()->intended('/reviewer');
            }
        }

        return back()->withErrors(['email' => 'Email or password is incorrect.'])->onlyInput('email');
    }

    /**
     * Handle forgot password form submission.
     */
    public function sendVerificationCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Mencari user berdasarkan email
        $user = User::where('email', $request->email)->first();
        dd($user);

        if (!$user) {
            // Mengirim respons JSON jika email tidak ditemukan
            return response()->json(['message' => 'Email tidak ditemukan.'], 400);
        }

        // Simpan email dalam session untuk verifikasi lebih lanjut
        session(['reset_email' => $user->email]);

        // Generate token verifikasi (kode unik)
        $token = Str::random(60);

        // Simpan token ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Kirim email verifikasi
        Mail::to($user->email)->send(new ResetPasswordMail($user->email, $token));

        return back()->with('status', 'Kode verifikasi telah dikirim ke email Anda.');
    }

    // 2. Verifikasi kode yang dimasukkan pengguna
    public function verifyCode(Request $request)
    {
        $request->validate([
            'auth_code' => 'required',  // Validasi auth_code yang dikirim
        ]);

        // Ambil email dari session
        $email = session('reset_email');  // Email yang sudah disimpan di session

        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Email tidak ditemukan dalam sesi.']);
        }

        // Cek apakah token dan email valid
        $token = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $request->auth_code)
            ->first();

        if (!$token) {
            return back()->withErrors(['auth_code' => 'Kode verifikasi tidak valid atau telah kedaluwarsa.']);
        }

        // Simpan token yang valid untuk proses reset password
        session(['reset_token' => $request->auth_code]);

        // Redirect ke halaman reset password
        return redirect()->route('password.reset');
    }

    // 3. Melakukan reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $email = session('reset_email');
        $token = session('reset_token');

        // Cek apakah token dan email valid
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$tokenData) {
            // Mengembalikan respon JSON jika token tidak valid atau sudah kedaluwarsa
            return response()->json([
                'error' => 'Token reset password tidak valid atau telah kedaluwarsa.'
            ], 400); // 400 untuk bad request
        }

        // Reset password pengguna
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Hapus token reset setelah password diubah
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Logout pengguna jika ada sesi aktif
        Auth::logout();

        // Mengembalikan respon JSON setelah reset password berhasil
        return response()->json([
            'message' => 'Password berhasil direset. Silakan login dengan password baru.'
        ]);
    }

    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}