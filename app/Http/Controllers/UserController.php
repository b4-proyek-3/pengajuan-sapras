<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengaju;
use App\Models\Reviewer;
use App\Models\Ormawa;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index(Request $request)
    {
        $activeTab = $request->input('active_tab', 'pengaju');
        $reviewer = Reviewer::with('user')->paginate(10, ['*'], 'reviewer_page');
        $pengaju = Pengaju::with('user')->paginate(10, ['*'], 'pengaju_page');
        $ormawa = Ormawa::all();
        return view('users.index', compact('pengaju', 'reviewer', 'ormawa', 'activeTab'));
    }

    // Menampilkan form untuk menambah user
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validasi input pengguna
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Membuat data pengguna
        $user = User::create([
            'name' => $validatedUser['name'],
            'email' => $validatedUser['email'],
            'password' => bcrypt($validatedUser['password']),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        if ($request->has('nim')) {
            $validatedPengaju = $request->validate([
                'nim' => 'required|size:9|unique:pengaju,nim',
                'id_ormawa' => 'required|exists:ormawa,id_ormawa',
            ]);

            $pengaju = Pengaju::create([
                'nim' => $validatedPengaju['nim'],
                'id_user' => $user->id_user,
                'id_ormawa' => $validatedPengaju['id_ormawa'],
            ]);

            return redirect()->route('users.index')->with('success', 'Pengaju berhasil ditambahkan.');
        } elseif ($request->has('role')) {
            // Validasi input Reviewer
            $validatedReviewer = $request->validate([
                'role' => 'required|in:sekum-bem,kli,wd-3',
            ]);

            // Membuat data Reviewer
            $reviewer = Reviewer::create([
                'id_user' => $user->id_user, // Menggunakan id_user dari data pengguna
                'role' => $validatedReviewer['role'], // Role reviewer
            ]);

            return redirect()->route('users.index')->with('success', 'Reviewer berhasil ditambahkan.');
        }

        // Jika tidak ada nim atau role
        return redirect()->route('users.index')->with('error', 'Tidak ada data yang valid untuk disimpan.');
    }

    // Menampilkan form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Memperbarui user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id_user',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    // Menampilkan daftar reviewer
    public function manageReviewers()
    {
        $reviewers = Reviewer::with('user')->get();
        return view('reviewers.index', compact('reviewers'));
    }

    // Menampilkan daftar pengaju
    public function managePengaju()
    {
        $pengaju = Pengaju::with('user')->get();
        return view('pengaju.index', compact('pengaju'));
    }
}
