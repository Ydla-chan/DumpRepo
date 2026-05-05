<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    
    // ===================================
    // ✅ REGISTER
    // ===================================
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|min:3',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6',

        ], [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah pernah digunakan',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'is_verified' => true,
        ]);

        return redirect()->route('login.form')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }


    // ===================================
    // ✅ LOGIN
    // ===================================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        // ❌ Jika email tidak terdaftar
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email belum terdaftar.'
            ])->withInput();
        }

        // ❌ Jika password salah
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.'
            ])->withInput();
        }

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Login berhasil!');
    }


    // ===================================
    // ✅ LOGOUT
    // ===================================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
