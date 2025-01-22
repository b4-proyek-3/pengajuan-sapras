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
            $validatedReviewer = $request->validate([
                'role' => 'required|in:sekum-bem,kli,wd-3',
            ]);

            $reviewer = Reviewer::create([
                'id_user' => $user->id_user,
                'role' => $validatedReviewer['role'],
            ]);

            return redirect()->route('users.index')->with('success', 'Reviewer berhasil ditambahkan.');
        }

        return redirect()->route('users.index')->with('error', 'Tidak ada data yang valid untuk disimpan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|string|min:8',
        ]);
        
        $user = User::findOrFail($id);

        // Update data pengguna
        $user->update([
            'name' => $validatedUser['name'],
            'email' => $validatedUser['email'],
            'password' => $request->password ? bcrypt($validatedUser['password']) : $user->password,
        ]);

        // Jika data yang diperbarui adalah Pengaju
        if ($request->has('nim')) {
            $validatedPengaju = $request->validate([
                'nim' => 'required|size:9|unique:pengaju,nim,' . $id . ',id_user',
                'id_ormawa' => 'required|exists:ormawa,id_ormawa',
            ]);

            $pengaju = Pengaju::where('id_user', $user->id_user)->firstOrFail();
            $pengaju->update([
                'nim' => $validatedPengaju['nim'],
                'id_ormawa' => $validatedPengaju['id_ormawa'],
            ]);

            return redirect()->route('users.index')->with('success', 'Data Pengaju berhasil diperbarui.');
        }

        // Jika data yang diperbarui adalah Reviewer
        if ($request->has('role')) {
            $validatedReviewer = $request->validate([
                'role' => 'required|in:sekum-bem,kli,wd-3',
            ]);

            $reviewer = Reviewer::where('id_user', $user->id_user)->firstOrFail();
            $reviewer->update([
                'role' => $validatedReviewer['role'],
            ]);

            return redirect()->route('users.index')->with('success', 'Data Reviewer berhasil diperbarui.');
        }

        return redirect()->route('users.index')->with('error', 'Tidak ada data yang valid untuk diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
