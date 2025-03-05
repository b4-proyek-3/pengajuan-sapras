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
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRoleSelection()
    {
        if (Auth::check()) {
            return redirect()->route('pengajuan.index'); // Redirect jika sudah login
        }
        return view('pages.Auth.role');
    }
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
                'regex:/^[a-zA-Z0-9._%+-]+@polban\.ac\.id$/i',
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

        // Cek apakah email ada di database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 400);
        }

        // Simpan email dalam session
        session(['reset_email' => $user->email]);

        // Generate token
        $token = rand(100000, 999999);

        // Simpan ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Kirim email verifikasi
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user->email, $token));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Gagal mengirim email.'], 500);
        }

        Log::info('Kode verifikasi dikirim ke: ' . $user->email);
        return response()->json(['message' => 'Code sent!'], 200);
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
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak ditemukan dalam sesi.'
            ], 400);
        }

        // Cek apakah token dan email valid
        $token = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $request->auth_code)
            ->first();

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode verifikasi tidak valid atau telah kedaluwarsa.'
            ], 400);
        }

        // Simpan token yang valid untuk proses reset password
        session(['reset_token' => $request->auth_code]);

        // Return success message
        return response()->json(['message' => 'Verified!'], 200);
    }

    // 3. Melakukan reset password
    public function resetPassword(Request $request)
    {
        // Pastikan permintaan menerima JSON
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Request must accept JSON'], 406);
        }

        // Validasi input
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        // Ambil email dan token dari session
        $email = session('reset_email');
        $token = session('reset_token');

        // Cek apakah token dan email valid
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$tokenData) {
            return response()->json([
                'error' => 'Token reset password tidak valid atau telah kedaluwarsa.'
            ], 400);
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

        return response()->json([
            'message' => 'Password berhasil direset. Silakan login dengan password baru.'
        ], 200);
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