<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\Notulen;
use App\Models\PokokBahasan;
use App\Models\Keputusan;
use App\Models\Tindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotulenController extends Controller
{
    /**
     * Tampilkan daftar rapat untuk dipilih sebelum membuat notulen.
     */
    public function selectRapat()
    {
        $rapats = Rapat::with('notulen')->get();
        $notulens = Notulen::all();
        return view('global.notulenselection', compact('rapats', 'notulens'));
    }

    /**
     * Tampilkan form pembuatan notulen untuk rapat yang dipilih.
     */
    public function create(Request $request)
    {
        $rapatId = $request->get('rapat_id');
        $rapat = Rapat::findOrFail($rapatId);

        // Ambil notulen jika sudah ada
        $notulen = Notulen::where('rapat_id', $rapatId)->first();

        // Ambil data dari relasi model (bukan atribut tidak ada)
        $bahasan = $notulen ? $notulen->pokokBahasans : collect();
        $keputusan = collect();
        $tindakan = collect();

        if ($notulen) {
            foreach ($notulen->pokokBahasans as $pb) {
                $keputusan = $keputusan->merge($pb->keputusans);
                foreach ($pb->keputusans as $k) {
                    $tindakan = $tindakan->merge($k->tindakans);
                }
            }
        }

        return view('global.notulen', compact('rapat', 'notulen', 'bahasan', 'keputusan', 'tindakan'));
    }

    /**
     * Simpan notulen baru yang terhubung ke rapat.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rapat_id' => 'required|exists:rapats,id',
            'ringkasan' => 'required|string|max:1000',
        ]);

        $notulen = Notulen::create([
            'rapat_id' => $request->rapat_id,
            'judul' => $request->judul ?? 'Notulen Rapat',
            'tanggal' => now(),
            'pembuat_id' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notulen berhasil dibuat',
                'data' => $notulen,
            ]);
        }

        return redirect()->route('global.notulen', $notulen->id)
                         ->with('success', 'Notulen berhasil dibuat.');
    }

    /**
     * Tampilkan detail lengkap notulen.
     */
public function show($notulenId)
{
    $notulen = Notulen::with(['rapat', 'pokokBahasan.keputusan.tindakan'])->findOrFail($notulenId);

    $rapat = $notulen->rapat; // ambil relasi rapat

    return view('global.notulen', compact('notulen', 'rapat' ,'PokokBahasan','keputusan','Tindakan'));
}

    /**
     * Tambahkan pokok bahasan baru ke notulen.
     */
    public function storePokokBahasan(Request $request, $notulenId)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
            ]);

            $notulen = Notulen::findOrFail($notulenId);

            $pokok = $notulen->pokokBahasans()->create([
                'judul' => $request->judul,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pokok bahasan berhasil ditambahkan',
                    'data' => $pokok,
                ]);
            }

            return back()->with('success', 'Pokok bahasan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storePokokBahasan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan pokok bahasan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tambahkan keputusan baru ke pokok bahasan.
     */
    public function storeKeputusan(Request $request, $pokokId)
    {
        try {
            $request->validate([
                'isi_keputusan' => 'required|string|max:500',
            ]);

            $pokok = PokokBahasan::findOrFail($pokokId);

            $keputusan = $pokok->keputusans()->create([
                'isi_keputusan' => $request->isi_keputusan,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Keputusan berhasil ditambahkan',
                    'data' => $keputusan,
                ]);
            }

            return back()->with('success', 'Keputusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storeKeputusan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan keputusan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tambahkan tindakan baru ke keputusan.
     */
    public function storeTindakan(Request $request, $keputusanId)
    {
        try {
            $request->validate([
                'deskripsi' => 'required|string|max:500',
                'pic_id' => 'required|exists:users,id',
                'deadline' => 'nullable|date',
                'status' => 'nullable|string|max:50',
            ]);

            $keputusan = Keputusan::findOrFail($keputusanId);

            $tindakan = $keputusan->tindakans()->create([
                'deskripsi' => $request->deskripsi,
                'pic_id' => $request->pic_id,
                'deadline' => $request->deadline,
                'status' => $request->status ?? 'Belum Selesai',
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tindakan berhasil ditambahkan',
                    'data' => $tindakan,
                ]);
            }

            return back()->with('success', 'Tindakan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storeTindakan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan tindakan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export notulen ke PDF (opsional).
     */
    public function exportPDF($id)
    {
        $notulen = Notulen::with([
            'rapat',
            'pokokBahasans.keputusans.tindakans.pic'
        ])->findOrFail($id);

        return response()->json([
            'message' => 'Fitur export PDF masih dalam pengembangan',
            'notulen' => $notulen
        ]);
    }
}
