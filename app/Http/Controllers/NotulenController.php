<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\Notulen;
use App\Models\Tindakan;
use App\Models\Keputusan;
use App\Models\PokokBahasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // Cek apakah notulen untuk rapat ini sudah ada
        $notulen = Notulen::where('rapat_id', $rapatId)->first();

        // Ambil relasi jika sudah ada notulen
        $bahasan = $notulen ? $notulen->pokokBahasans : collect();
        $keputusan = collect();
        $tindakan = collect();

        if ($notulen) {
            foreach ($bahasan as $pb) {
                $keputusan = $keputusan->merge($pb->keputusans);
                foreach ($pb->keputusans as $k) {
                    $tindakan = $tindakan->merge($k->tindakans);
                }
            }
        }

        return view('global.notulen', compact('rapat', 'notulen', 'bahasan', 'keputusan', 'tindakan'));
    }

    /**
     * Simpan/Update notulen dan semua data nested (Pokok Bahasan, Keputusan, Tindakan)
     */
    public function store(Request $request)
    {
        Log::info('📩 Data diterima di NotulenController@store', $request->all());

        try {
            $data = $request->json()->all();
            if (empty($data)) {
                $data = $request->all();
            }

            Log::info('📦 Data setelah parsing:', $data);

            // Validasi
            $validated = validator($data, [
                'rapat_id'   => 'required|integer|exists:rapats,id',
                'pembuat_id' => 'nullable|integer|exists:users,id',
                'notulen_id' => 'nullable|integer|exists:notulens,id',
                'judul'      => 'required|string',
                'tanggal'    => 'required|date',
                'pokok_bahasan' => 'required|array',
                'pokok_bahasan.*.judul' => 'required|string',
                'pokok_bahasan.*.keputusan' => 'array',
                'pokok_bahasan.*.keputusan.*.isi_keputusan' => 'required|string',
                'pokok_bahasan.*.keputusan.*.tindakan' => 'array',
                'pokok_bahasan.*.keputusan.*.tindakan.*.deskripsi' => 'required|string',
                'pokok_bahasan.*.keputusan.*.tindakan.*.pic_id' => 'required|exists:users,id',
                'pokok_bahasan.*.keputusan.*.tindakan.*.deadline' => 'nullable|date',
            ])->validate();

            DB::beginTransaction();

            // 🔍 Jika notulen_id ada → gunakan notulen yang sudah ada
            if (!empty($validated['notulen_id'])) {
                $notulen = Notulen::findOrFail($validated['notulen_id']);
                Log::info('📝 Menggunakan notulen yang sudah ada', ['id' => $notulen->id]);
                
                // Update data notulen
                $notulen->update([
                    'judul' => $validated['judul'],
                    'tanggal' => $validated['tanggal'],
                    'pembuat_id' => $validated['pembuat_id'] ?? auth()->id(),
                ]);
            } else {
                // ✨ Jika belum ada notulen_id → buat baru
                $notulen = Notulen::create([
                    'rapat_id'   => $validated['rapat_id'],
                    'judul'      => $validated['judul'],
                    'tanggal'    => $validated['tanggal'],
                    'pembuat_id' => $validated['pembuat_id'] ?? auth()->id(),
                ]);
            }

            // HAPUS SEMUA DATA LAMA (PokokBahasan, Keputusan, Tindakan) sebelum menyimpan yang baru
            // Ini yang memungkinkan penghapusan item dari draft di frontend bekerja!
            $notulen->pokokBahasans()->delete();

            // Simpan pokok bahasan, keputusan, tindakan (YANG BARU dari draft)
            if (!empty($data['pokok_bahasan'])) {
                foreach ($data['pokok_bahasan'] as $pokok) {
                    $bahasan = $notulen->pokokBahasans()->create([
                        'judul' => $pokok['judul']
                    ]);

                    if (!empty($pokok['keputusan'])) {
                        foreach ($pokok['keputusan'] as $keputusan) {
                            $kep = $bahasan->keputusans()->create([
                                'isi_keputusan' => $keputusan['isi_keputusan']
                            ]);

                            if (!empty($keputusan['tindakan'])) {
                                foreach ($keputusan['tindakan'] as $tindakan) {
                                    $kep->tindakans()->create([
                                        'deskripsi' => $tindakan['deskripsi'],
                                        'pic_id'    => $tindakan['pic_id'],
                                        'deadline'  => $tindakan['deadline'] ?? null,
                                        'status' => $tindakan['status'] ?? 'Pending', // Asumsi default status
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan ke notulen!',
                'notulen_id' => $notulen->id,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            
            Log::error('❌ Gagal menyimpan notulen: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tampilkan detail lengkap notulen.
     */
    public function show($notulenId)
    {
        $notulen = Notulen::with(['rapat', 'pokokBahasans.keputusans.tindakans.pic'])->findOrFail($notulenId);
        $rapat = $notulen->rapat;

        // Kumpulkan data terstruktur
        $bahasan = $notulen->pokokBahasans;
        $keputusan = collect();
        $tindakan = collect();

        foreach ($bahasan as $pb) {
            $keputusan = $keputusan->merge($pb->keputusans);
            foreach ($pb->keputusans as $k) {
                $tindakan = $tindakan->merge($k->tindakans);
            }
        }

        return view('global.notulen', compact('notulen', 'rapat', 'bahasan', 'keputusan', 'tindakan'));
    }
    
    // --- FUNGSI CREATE CHILD (Tidak diubah) ---
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

            return $request->ajax()
                ? response()->json(['success' => true, 'message' => 'Pokok bahasan berhasil ditambahkan', 'data' => $pokok])
                : back()->with('success', 'Pokok bahasan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storePokokBahasan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan pokok bahasan', 'error' => $e->getMessage()], 500);
        }
    }

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

            return $request->ajax()
                ? response()->json(['success' => true, 'message' => 'Keputusan berhasil ditambahkan', 'data' => $keputusan])
                : back()->with('success', 'Keputusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storeKeputusan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan keputusan', 'error' => $e->getMessage()], 500);
        }
    }

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
                'status' => $request->status ?? 'pending',
            ]);

            return $request->ajax()
                ? response()->json(['success' => true, 'message' => 'Tindakan berhasil ditambahkan', 'data' => $tindakan])
                : back()->with('success', 'Tindakan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storeTindakan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan tindakan', 'error' => $e->getMessage()], 500);
        }
    }

    // --- FUNGSI HAPUS (DELETE) ---

    /**
     * Hapus Notulen utama dan semua relasi anaknya.
     */
    public function destroy(Notulen $notulen)
    {
        try {
            // Asumsi: Relasi sudah di-set CASCADE ON DELETE di migrasi
            // Jika tidak, Anda perlu menghapus PokokBahasan, Keputusan, dan Tindakan secara manual
            // $notulen->pokokBahasans()->delete(); // Ini akan menghapus semua anak jika relasi sudah benar
            
            $notulen->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notulen berhasil dihapus secara permanen.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Gagal menghapus notulen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus notulen. Terjadi kesalahan server.'
            ], 500);
        }
    }

    /**
     * Hapus Pokok Bahasan tertentu (Opsional, jika ingin hapus langsung tanpa draft store).
     */
    public function destroyPokokBahasan(PokokBahasan $pokok)
    {
        try {
            $pokok->delete();
            return response()->json(['success' => true, 'message' => 'Pokok Bahasan berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus Pokok Bahasan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Pokok Bahasan.'], 500);
        }
    }

    /**
     * Hapus Keputusan tertentu (Opsional).
     */
    public function destroyKeputusan(Keputusan $keputusan)
    {
        try {
            $keputusan->delete();
            return response()->json(['success' => true, 'message' => 'Keputusan berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus Keputusan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Keputusan.'], 500);
        }
    }

    /**
     * Hapus Tindakan tertentu (Opsional).
     */
    public function destroyTindakan(Tindakan $tindakan)
    {
        try {
            $tindakan->delete();
            return response()->json(['success' => true, 'message' => 'Tindakan berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus Tindakan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Tindakan.'], 500);
        }
    }
    
    // --- FUNGSI LAIN ---

    /**
     * Export notulen ke PDF (opsional).
     */
    public function exportPDF($id)
    {
        $notulen = Notulen::with(['rapat', 'pokokBahasans.keputusans.tindakans.pic'])->findOrFail($id);

        return response()->json([
            'message' => 'Fitur export PDF masih dalam pengembangan',
            'notulen' => $notulen,
        ]);
    }
}