<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $otp = rand(100000, 999999);

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'otp_code'       => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
            'is_verified'    => false,
        ]);

        session(['verify_email' => $user->email]);
        $this->sendOtp($user->email, $otp);

        return redirect()->route('verify.register.form')
            ->with('success', 'Registrasi berhasil! OTP dikirim ke email Anda.');
    }

    public function verifyRegisterOtp(Request $request)
    {
        $email = $request->email ?? session('verify_email');
        if (!$email) {
            return redirect()->route('register.form')
                ->withErrors(['email' => 'Session verifikasi hilang, silakan registrasi ulang.']);
        }

        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $email)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'OTP salah atau kadaluarsa.']);
        }

        $user->update([
            'is_verified'    => true,
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);

        session()->forget('verify_email');

        return redirect()->route('login.form')
            ->with('success', 'Akun berhasil diverifikasi! Silakan login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        if (!$user->is_verified) {
            return back()->withErrors(['email' => 'Akun belum diverifikasi, cek email OTP registrasi.']);
        }

        $otp = rand(100000, 999999);
        $user->update([
            'otp_code'       => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        session(['verify_email' => $user->email]);
        $this->sendOtp($user->email, $otp);

        return redirect()->route('verify.login.form')
            ->with('success', 'OTP login telah dikirim ke email Anda.');
    }

    public function verifyLoginOtp(Request $request)
    {
        $email = $request->email ?? session('verify_email');
        if (!$email) {
            return redirect()->route('login.form')
                ->withErrors(['email' => 'Session verifikasi hilang, silakan login ulang.']);
        }

        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $email)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'OTP salah atau kadaluarsa.']);
        }

        $user->update([
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);

        session()->forget('verify_email');

        Auth::login($user);
        // Jika ada redirect_after_login (di-set saat akses route perlu login), redirect ke sana
        $redirect = session('redirect_after_login') ?? session()->pull('redirect_after_login');
        if ($redirect) {
            // Hapus session dan redirect ke URL target
            session()->forget('redirect_after_login');
            return redirect($redirect)->with('success', 'Login berhasil!');
        }

        // fallback kalau role belum di-set
        return redirect()->route('dashboard')
            ->with('success', 'Login berhasil!');
    }

    private function sendOtp($email, $otp)
    {
        Mail::to($email)->send(new SendOtpMail($otp));
    }

  public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

           return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
