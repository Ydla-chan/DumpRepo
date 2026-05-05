<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rapat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RapatUndanganMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import untuk QR Code


class RapatController extends Controller
{
    public function index()
    { 
            $email = auth()->user()->email;
    $userId = Auth::id();

    // Include notulen dengan ringkasannya untuk ditampilkan di halaman jadwal
    $rapats = Rapat::with('notulen:id,rapat_id,judul,ringkasan,ringkasan_generated_at,pembuat_id')
        ->where(function ($q) use ($email, $userId) {
                    $q->whereJsonContains('undangan', $email) // rapat diundang
                      ->orWhere('pembuat_id', $userId);      // rapat yang dia buat sendiri
                })
                ->orderBy('tanggal', 'desc')
                ->paginate(10);

    return view('rapatviews', compact('rapats'));
    }
    

    public function store(Request $request)
    {
        // 1. Validasi input dari form, termasuk undangan
        $validator = Validator::make($request->all(), [
            'judul'       => 'required|string|max:255',
            'agenda'      => 'required|string|max:255',
            'tanggal'     => 'required|date',
            'jam'         => 'required|date_format:H:i',
            'tipe_lokasi' => 'required|in:online,offline',
            'lokasi'      => 'required|string|max:255',
            'undangan'    => 'nullable|array',      // Validasi untuk array undangan
            'undangan.*'  => 'nullable|email',    // Validasi setiap item dalam array adalah email
        ]);

        // Jika validasi gagal, kirim kembali error dalam format JSON
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. Jika validasi berhasil, siapkan data untuk disimpan
        try {
            // Siapkan data dasar
            $dataToSave = [
                'judul'         => $request->judul,
                'agenda'        => $request->agenda,
                'tanggal'       => $request->tanggal,
                'jam'           => $request->jam,
                'tipe_lokasi'   => $request->tipe_lokasi,
                'undangan'      => $request->undangan ?? [], 
                'pembuat_id'    => Auth()->id(), // Simpan ID pembuat rapat
            ];

            // Logika Kondisi Lokasi Rapat 
            if ($request->tipe_lokasi === 'online') {
                $dataToSave['link'] = $request->lokasi;
                $dataToSave['ruangan'] = null; // Pastikan ruangan kosong
            } else {
                $dataToSave['ruangan'] = $request->lokasi;
                $dataToSave['link'] = null; // Pastikan link kosong
            }

            // Buat record baru dan simpan objeknya ke variabel $rapat
            $rapat = Rapat::create($dataToSave);

            // --- 3. LOGIKA PENGIRIMAN EMAIL ---
            if (!empty($rapat->undangan)) {
                foreach ($rapat->undangan as $email) {
                    // Kirim email ke setiap alamat menggunakan Mailable
                    Mail::to($email)->send(new RapatUndanganMail($rapat));
                }
            }
            // --- AKHIR LOGIKA PENGIRIMAN EMAIL ---

            // 4. Kirim respons sukses
            return response()->json(['message' => 'Rapat berhasil dibuat dan undangan telah dikirim!'], 201);

        } catch (\Exception $e) {
            // Log error untuk membantu debugging di masa depan
            Log::error('Gagal menyimpan rapat atau mengirim email: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }
    
    /**
     * Mengambil detail rapat berdasarkan ID.
     * Digunakan oleh modal detail di frontend.
     */
    public function showDetails($id)
    {
     $rapat = Rapat::with('notulen')->findOrFail($id);
        return response()->json([
            'id' => $rapat->id, // Tambahkan ID rapat
            'judul' => $rapat->judul,
            'agenda' => $rapat->agenda,
            'tanggal' => $rapat->tanggal->format('Y-m-d'), // Format ISO untuk JS
            'jam' => $rapat->jam,
            'tipe_lokasi' => $rapat->tipe_lokasi,
            'ruangan' => $rapat->ruangan,
            'link' => $rapat->link,
            
     
          // ✅ Tambahkan Notulen dengan ringkasan
        'notulen_id'  => $rapat->notulen ? $rapat->notulen->id : null,
        'notulen_ada' => $rapat->notulen ? true : false,
        'ringkasan'   => $rapat->notulen ? $rapat->notulen->ringkasan : null,
        'notulen_url' => $rapat->notulen ? "/rapat/{$rapat->id}/notulen" : null,
      
        ]);
    }

    /**
     * Menghasilkan QR Code untuk absensi rapat.
     * Data QR mengarah ke halaman absensi universal dengan parameter rapat_id.
     */
    public function generateQrCode(Rapat $rapat)
    {
        // Pastikan setiap rapat punya attendance_token unik
        if (empty($rapat->attendance_token)) {
            $rapat->attendance_token = Str::random(40);
            $rapat->save();
        }

        // URL mengarah ke quick/auto scan sehingga QR langsung mencatat kehadiran
        $absensiUrl = url("/absensi/scan/auto?rapat_id=" . $rapat->id . "&key=" . $rapat->attendance_token);
    
        return QrCode::size(200) 
                     ->margin(2)   
                     ->color(0, 0, 0) 
                     ->format('svg')
                     ->generate($absensiUrl);
    }


    public function showNotulenPage($id)
{
    $rapat = Rapat::with('notulen')->findOrFail($id);

    if (!$rapat->notulen) {
        return redirect()->back()->with('error', 'Notulen belum tersedia.');
    }

    return view('notulenpage', [
        'rapat'   => $rapat,
        'notulen' => $rapat->notulen
    ]);
}


public function rekomendasiJadwalGlobal()
{
    // ===============================
    // 1️⃣ Ambil histori (hari + jam)
    // ===============================
    $histori = Rapat::selectRaw('
            DAYOFWEEK(tanggal) as hari,
            HOUR(jam) as jam,
            COUNT(*) as total
        ')
        ->groupBy('hari', 'jam')
        ->orderByDesc('total')
        ->get();

    // ===============================
    // 2️⃣ Slot yang sudah terpakai
    // ===============================
    $existing = Rapat::select('tanggal', 'jam')->get()
        ->map(fn ($r) => $r->tanggal . ' ' . substr($r->jam, 0, 5))
        ->toArray();

    $startDate = Carbon::now()->startOfDay();

    // ===============================
    // 3️⃣ Cari (hari + jam) favorit yang kosong
    // ===============================
    foreach ($histori as $row) {
        $hari = $row->hari; // 1=Sunday, 2=Monday, ..., 7=Saturday
        $jam  = (int) $row->jam;

        // Lewati Sabtu & Minggu
        if ($hari == 1 || $hari == 7) continue;

        // Jam kerja saja
        if ($jam < 9 || $jam > 16) continue;

        // Cari tanggal terdekat dengan hari tsb
        for ($d = 0; $d < 14; $d++) {
            $date = $startDate->copy()->addDays($d);

            if ($date->dayOfWeekIso + 1 != $hari) continue;

            $jamStr = sprintf('%02d:00', $jam);
            $slotKey = $date->format('Y-m-d') . ' ' . $jamStr;

            if (!in_array($slotKey, $existing)) {
                return response()->json([
                    'success' => true,
                    'rekomendasi' => [
                        'tanggal' => $date->format('Y-m-d'),
                        'jam' => $jamStr,
                        'alasan' => 'Hari & jam rapat paling sering digunakan dan masih kosong'
                    ]
                ]);
            }
        }
    }

    // ===============================
    // 4️⃣ FALLBACK: slot kosong pertama
    // ===============================
    for ($d = 0; $d < 14; $d++) {
        $date = $startDate->copy()->addDays($d);

        if ($date->isWeekend()) continue;

        for ($jam = 9; $jam <= 16; $jam++) {
            $jamStr = sprintf('%02d:00', $jam);
            $slotKey = $date->format('Y-m-d') . ' ' . $jamStr;

            if (!in_array($slotKey, $existing)) {
                return response()->json([
                    'success' => true,
                    'rekomendasi' => [
                        'tanggal' => $date->format('Y-m-d'),
                        'jam' => $jamStr,
                        'alasan' => 'Slot kosong terdekat dalam jam kerja'
                    ]
                ]);
            }
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'Tidak ada slot jadwal tersedia'
    ]);
}
}
