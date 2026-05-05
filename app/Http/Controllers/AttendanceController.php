<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Show attendance form (universal scan page).
     */
    public function showForm(Request $request)
    {
        $rapatId = $request->query('rapat_id');
        
        if (!$rapatId) {
            return view('attendance.index', ['error' => 'Parameter rapat_id tidak ditemukan.']);
        }

        $rapat = Rapat::find($rapatId);
        if (!$rapat) {
            return view('attendance.index', ['error' => 'Rapat tidak ditemukan.']);
        }

        // Validasi token/key untuk memastikan QR khusus rapat ini
        $key = $request->query('key');
        if (empty($key) || $key !== $rapat->attendance_token) {
            return view('attendance.index', ['error' => 'Token QR tidak cocok atau tidak disertakan.']);
        }

        return view('attendance.index', ['rapat' => $rapat]);
    }

    /**
     * Handle form submission untuk absensi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rapat_id' => 'required|exists:rapats,id',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
        ]);

        $rapat = Rapat::find($request->rapat_id);

        // Cek jika sudah absen sebelumnya dengan email yang sama
        $existing = Attendance::where('rapat_id', $rapat->id)
            ->where('email', $request->email)
            ->first();

        if ($existing) {
            return view('attendance.result', [
                'status' => 'already',
                'existingAttendance' => $existing,
            ]);
        }

        // Simpan attendance (tanpa user_id, hanya nama & email)
        $attendance = Attendance::create([
            'rapat_id' => $rapat->id,
            'name' => $request->name,
            'email' => $request->email,
            'scanned_at' => Carbon::now(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return view('attendance.result', [
            'status' => 'success',
            'attendance' => $attendance,
        ]);
    }

    /**
     * Quick scan: langsung catat kehadiran ketika link dikunjungi (QR otomatis).
     * - Jika user login, gunakan user_id untuk mencegah duplikat.
     * - Jika guest, gunakan kombinasi IP + user agent untuk mencegah duplikat kasar.
     */
    public function quickScan(Request $request)
    {
        $rapatId = $request->query('rapat_id');
        if (!$rapatId) {
            return view('attendance.index', ['error' => 'Parameter rapat_id tidak ditemukan.']);
        }

        $rapat = Rapat::find($rapatId);
        if (!$rapat) {
            return view('attendance.index', ['error' => 'Rapat tidak ditemukan.']);
        }

        // Jika user terautentikasi, cek berdasarkan user_id
        if (Auth::check()) {
            $userId = Auth::id();
            $existing = Attendance::where('rapat_id', $rapat->id)
                ->where('user_id', $userId)
                ->first();

            if ($existing) {
                return view('attendance.result', [
                    'status' => 'already',
                    'existingAttendance' => $existing,
                ]);
            }

            $attendance = Attendance::create([
                'rapat_id' => $rapat->id,
                'user_id' => $userId,
                'name' => Auth::user()->name ?? null,
                'email' => Auth::user()->email ?? null,
                'scanned_at' => Carbon::now(),
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            return view('attendance.result', [
                'status' => 'success',
                'attendance' => $attendance,
            ]);
        }

        // Guest: gunakan ip + user_agent untuk deteksi duplikat sederhana
        $ip = $request->ip();
        $ua = $request->header('User-Agent');

        $existing = Attendance::where('rapat_id', $rapat->id)
            ->where('ip', $ip)
            ->where('user_agent', $ua)
            ->first();

        if ($existing) {
            return view('attendance.result', [
                'status' => 'already',
                'existingAttendance' => $existing,
            ]);
        }

        // Simpan sebagai guest (nama/email kosong)
        $attendance = Attendance::create([
            'rapat_id' => $rapat->id,
            'name' => null,
            'email' => null,
            'scanned_at' => Carbon::now(),
            'ip' => $ip,
            'user_agent' => $ua,
        ]);

        return view('attendance.result', [
            'status' => 'success',
            'attendance' => $attendance,
        ]);
    }

    /**
     * Show attendance list for a rapat.
     */
    public function showAbsensi(Rapat $rapat)
    {
        $attendances = $rapat->attendances()->get();
        return view('attendance.list', compact('rapat', 'attendances'));
    }
}
