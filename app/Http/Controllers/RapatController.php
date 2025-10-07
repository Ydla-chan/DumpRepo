<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RapatUndanganMail;

class RapatController extends Controller
{
    public function index()
    {
        // 1. Ambil data dari model Rapat
        // 2. Urutkan berdasarkan tanggal (terbaru dulu)
        // 3. Gunakan paginate untuk membatasi data per halaman (misal: 10)
        $rapats = Rapat::orderBy('tanggal', 'desc')->paginate(10);

        // 4. Kirim data 'rapats' ke view 'rekap-rapat'
        return view('rapatviews', ['rapats' => $rapats]);
    }
  

    public function store(Request $request)
    {
        // 1. Validasi input dari form, termasuk undangan
        $validator = Validator::make($request->all(), [
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
                'agenda'      => $request->agenda,
                'tanggal'     => $request->tanggal,
                'jam'         => $request->jam,
                'tipe_lokasi' => $request->tipe_lokasi,
                'undangan'    => $request->undangan ?? [], // Simpan array undangan
            ];

            // Logika Kondisi Lokasi Rapat 
            if ($request->tipe_lokasi === 'online') {
                $dataToSave['link'] = $request->lokasi;
            } else {
                $dataToSave['ruangan'] = $request->lokasi;
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
public function showDetails($id)
{
    $rapat = Rapat::find($id);
    return view('rapatviewswe', compact('rapat'));
}
}

