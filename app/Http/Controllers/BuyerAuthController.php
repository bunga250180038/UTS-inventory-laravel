<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class BuyerAuthController extends Controller
{
    /**
     * Menampilkan formulir registrasi pembeli.
     */
    public function showRegister()
    {
        return view('auth.register-buyer');
    }

    /**
     * Menyimpan akun pembeli baru.
     */
    public function register(Request $request)
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
                'confirmed',
                Password::min(8),
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'buyer',
        ]);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Akun pembeli berhasil dibuat. Silakan login untuk melihat katalog produk.'
            );
    }
}
