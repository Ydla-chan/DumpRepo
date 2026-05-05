<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\SendOtpMail;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $otp = random_int(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim OTP: ' . $e->getMessage()]);
        }

        return redirect()->route('password.verify.form', ['email' => $user->email])
                         ->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify-otp', [
            'email' => $email,
            'action' => route('password.verify'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Handle resend
        if ($request->has('resend')) {
            $otp = random_int(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(5);
            $user->save();

            try {
                Mail::to($user->email)->send(new SendOtpMail($otp));
            } catch (\Exception $e) {
                return back()->withErrors(['email' => 'Gagal mengirim ulang OTP: ' . $e->getMessage()]);
            }

            return back()->with('status', 'Kode OTP baru telah dikirim.');
        }

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp_code', $request->otp)
                    ->where('otp_expires_at', '>=', Carbon::now())
                    ->first();

        if (! $user) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau telah kedaluwarsa.']);
        }

        // mark session to allow password reset
        session(['password_reset_email' => $user->email]);

        return redirect()->route('password.reset.form')->with('status', 'OTP terverifikasi. Silakan buat password baru.');
    }

    public function showResetForm(Request $request)
    {
        $email = session('password_reset_email');
        if (! $email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Silakan minta kode OTP terlebih dahulu.']);
        }
        return view('auth.reset', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $email = session('password_reset_email');
        if (! $email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi reset tidak ditemukan. Silakan ulangi proses.']);
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            return redirect()->route('password.request')->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // clear session flag
        session()->forget('password_reset_email');

        return redirect()->route('login.form')->with('status', 'Password berhasil diubah. Silakan masuk.');
    }
}
