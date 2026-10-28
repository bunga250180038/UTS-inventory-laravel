<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan formulir tambah pengguna.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            // Admin dapat membuat akun Admin, Staff, atau Pembeli.
            'role' => [
                'required',
                Rule::in(['admin', 'staff', 'buyer']),
            ],
        ]);

        // Password otomatis di-hash oleh model User.
        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit pengguna.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            // Role Pembeli sekarang diizinkan.
            'role' => [
                'required',
                Rule::in(['admin', 'staff', 'buyer']),
            ],
        ]);

        // Admin tidak boleh mengubah role akunnya sendiri.
        if (
            auth()->id() === $user->id &&
            $validated['role'] !== 'admin'
        ) {
            throw ValidationException::withMessages([
                'role' => 'Akun Admin yang sedang digunakan tidak dapat diubah menjadi Staff atau Pembeli.',
            ]);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        // Password hanya diganti jika kolom diisi.
        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy(User $user)
    {
        // Tidak boleh menghapus akun yang sedang digunakan.
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        // Pastikan setidaknya ada satu Admin tersisa.
        if (
            $user->role === 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Admin terakhir tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
