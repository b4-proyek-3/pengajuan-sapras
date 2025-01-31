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
        $roles = [
            'sekum-bem' => 'BEM',
            'kli' => 'KLI',
            'wd-3' => 'WD3',
        ];
    
        // Menambahkan kolom 'role' yang sudah disesuaikan ke setiap item
        foreach ($reviewer as $r) {
            $r->role = $roles[$r->role] ?? $r->role; // Jika tidak ada di array, gunakan nilai asli
        }
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

    public function update(Request $request, $id_user)
    {
        try {
            // Validasi data pengguna (name, email, password)
            $validatedUser = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id_user . ',id_user',
                'password' => 'nullable|string|min:8',
            ]);

            // Cari pengguna berdasarkan ID
            $user = User::findOrFail($id_user);

            // Perbarui data pengguna
            $updateData = [
                'name' => $validatedUser['name'],
                'password' => $request->password ? bcrypt($validatedUser['password']) : $user->password,
            ];

            // Jika email diinput, gunakan email baru; jika tidak, gunakan email lama
            if (isset($validatedUser['email']) && $validatedUser['email'] !== $user->email) {
                $updateData['email'] = $validatedUser['email'];
            }

            $user->update($updateData);

            // Jika ada 'nim', update Pengaju
            if ($request->has('nim')) {
                // Validasi data Pengaju
                $validatedPengaju = $request->validate([
                    'nim' => 'nullable|size:9|unique:pengaju,nim,' . $id_user . ',id_user',
                    'id_ormawa' => 'nullable|exists:ormawa,id_ormawa',
                ]);

                // Cari data Pengaju
                $pengaju = Pengaju::where('id_user', $user->id_user)->firstOrFail();

                // Perbarui data Pengaju
                $pengaju->update([
                    'nim' => $validatedPengaju['nim'],
                    'id_ormawa' => $validatedPengaju['id_ormawa'],
                ]);

                return redirect()->route('users.index')->with('success', 'Data Pengaju berhasil diperbarui.');
            } 

            // Jika ada 'role', update Reviewer
            elseif ($request->has('role')) {
                // Validasi data Reviewer
                $validatedReviewer = $request->validate([
                    'role' => 'nullable|in:BEM,KLI,WD3',
                ]);

                $roleMapping = [
                    'BEM' => 'sekum-bem',
                    'KLI' => 'kli',
                    'WD3' => 'wd-3',
                ];

                // Jika ada role yang valid, maka sesuaikan dengan role yang dipetakan
                if (isset($validatedReviewer['role'])) {
                    $validatedReviewer['role'] = $roleMapping[$validatedReviewer['role']] ?? $validatedReviewer['role'];

                    // Cari data Reviewer
                    $reviewer = Reviewer::where('id_user', $user->id_user)->first();

                    // Jika Reviewer tidak ditemukan, buat entri baru
                    if (!$reviewer) {
                        $reviewer = new Reviewer;
                        $reviewer->id_user = $user->id_user;  // Pastikan id_user di set dengan benar
                    }

                    // Perbarui data Reviewer
                    $reviewer->role = $validatedReviewer['role'];
                    $reviewer->save();

                    return redirect()->route('users.index')->with('success', 'Data Reviewer berhasil diperbarui.');
                }
            }

            return redirect()->route('users.index')->with('error', 'Tidak ada data yang valid untuk diperbarui.');

        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
