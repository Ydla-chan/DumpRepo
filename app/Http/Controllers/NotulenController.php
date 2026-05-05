<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\Notulen;
use App\Models\Tindakan;
use App\Models\Keputusan;
use App\Models\PokokBahasan;
use App\Services\NotulenSummaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class NotulenController extends Controller
{
    /**
     * Tampilkan daftar rapat untuk dipilih sebelum membuat notulen.
     */
  public function selectRapat()
{
    $userId = Auth::id();
    $emailUser = Auth::user()->email;

    // 1️⃣ Rapat yang dibuat user login (owner)
    $rapats = Rapat::with('notulen')
        ->where('pembuat_id', $userId)
        ->orderBy('tanggal', 'desc')
        ->get();

    // 2️⃣ Notulen yang dibuat user login sendiri
    $notulenOwner = Notulen::with('rapat')
        ->where('pembuat_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    // 3️⃣ Notulen dari rapat yang user login diundang & sudah published
    $notulenShared = Notulen::with('rapat')
        ->whereHas('rapat', function ($q) use ($emailUser) {
            $q->whereJsonContains('undangan', $emailUser);
        })
        ->where('is_published', 1)
        ->orderBy('created_at', 'desc')
        ->get();

    // 4️⃣ Gabungkan owner + shared (hapus duplicate)
    $notulens = $notulenOwner->merge($notulenShared)->unique('id');

    return view('global.notulenselection', compact('rapats', 'notulens'));
}
    /**
     * Tampilkan form pembuatan notulen untuk rapat yang dipilih.
     */
    public function create(Request $request)
    {
        $rapatId = $request->get('rapat_id');
        $rapat = Rapat::with('pembuat')->findOrFail($rapatId);

        
        $isOwner = $rapat->pembuat_id === Auth::id();

        $hadirUsers = $rapat->attendances()->with('user')->get()->pluck('user');
        $semuaPeserta = collect($rapat->undangan)
            ->push($rapat->pembuat->email ?? null)
            ->filter();

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

        return view('global.notulen', compact('rapat', 'notulen', 'bahasan', 'keputusan', 'tindakan', 'hadirUsers', 'semuaPeserta' , 'isOwner'));
    }

    /**
     * Simpan/Update notulen dan semua data nested (Pokok Bahasan, Keputusan, Tindakan)
     */
    public function store(Request $request)
    {
         $userId = Auth::id();
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
                                        'status' => $tindakan['status'] ?? 'pending',
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



     $notulen = Notulen::with(['rapat.pembuat', 'pokokBahasans.keputusans.tindakans.pic'])
            ->findOrFail($notulenId);

        $rapat = $notulen->rapat;
        $isOwner = $rapat->pembuat_id === Auth::id();
    // Data rapat & turunannya
    $bahasan = $notulen->pokokBahasans;
    $keputusan = collect();
    $tindakan = collect();

    foreach ($bahasan as $pb) {
        $keputusan = $keputusan->merge($pb->keputusans);
        foreach ($pb->keputusans as $k) {
            $tindakan = $tindakan->merge($k->tindakans);
        }
    }

    // ✅ Ambil daftar user yang hadir dari scan QR
    $hadirUsers = $rapat->attendances()->with('user')->get()->pluck('user');

    // ✅ Ambil semua anggota undangan + pembuat rapat (yang seharusnya hadir walau belum absensi)
    $semuaPeserta = collect($rapat->undangan)
        ->push($rapat->pembuat->email ?? null)
        ->filter();

    return view('global.notulen', compact(
        'notulen', 'rapat', 'bahasan', 'keputusan', 'tindakan', 'hadirUsers', 'semuaPeserta', 'isOwner'
    ));
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

       $rapat = $notulen->rapat;

        if ($rapat->pembuat_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus notulen ini.'
            ], 403);
        }

        try {
            $notulen->delete();
            return response()->json([
                'success' => true,
                'message' => 'Notulen berhasil dihapus.'
            ], 200);
        } catch (\Throwable $e) {
            Log::error('❌ Error hapus notulen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus notulen.'
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
    

    /**
     * Generate dan simpan ringkasan notulen
     */
    public function generateSummary($notulenId)
    {
        try {
            $notulen = Notulen::with('pokokBahasans.keputusans.tindakans.pic')->findOrFail($notulenId);
            $rapat = $notulen->rapat;

            // Hanya owner rapat yang boleh generate ringkasan
            if ($rapat->pembuat_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk generate ringkasan notulen ini.'
                ], 403);
            }

            // Generate ringkasan menggunakan service
            $summaryService = new NotulenSummaryService();
            $summaryService->saveSummary($notulen);

            return response()->json([
                'success' => true,
                'message' => 'Ringkasan notulen berhasil dibuat!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error generate summary: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat ringkasan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan ringkasan notulen
     */
    public function showSummary($notulenId)
    {
        try {
            $notulen = Notulen::findOrFail($notulenId);

            // Jika belum ada ringkasan, generate terlebih dahulu
            if (!$notulen->ringkasan) {
                $summaryService = new NotulenSummaryService();
                $summaryService->saveSummary($notulen);
                $notulen = Notulen::find($notulenId); // Refresh untuk mendapatkan ringkasan terbaru
            }

            return view('global.ringkasan-notulen', compact('notulen'));
        } catch (\Exception $e) {
            Log::error('Error show summary: ' . $e->getMessage());
            return back()->with('error', 'Gagal menampilkan ringkasan');
        }
    }

    /**
     * API endpoint untuk mendapatkan ringkasan dalam format JSON
     */
    public function getSummaryJson($notulenId)
    {
        try {
            $notulen = Notulen::findOrFail($notulenId);

            $summaryService = new NotulenSummaryService();
            $summary = $summaryService->generateSummaryJson($notulen);

            return response()->json([
                'success' => true,
                'data' => $summary
            ]);
        } catch (\Exception $e) {
            Log::error('Error get summary json: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan ringkasan: ' . $e->getMessage()
            ], 500);
        }
    }

public function publish($notulenId)
{
    $notulen = Notulen::with('rapat')->findOrFail($notulenId);
    $rapat = $notulen->rapat;

    // hanya owner rapat yg boleh publish
    if ($rapat->pembuat_id !== Auth::id()) {
        return response()->json([
            'success' => false,
            'message' => 'Anda tidak memiliki izin publish notulen ini.'
        ], 403);
    }

    $notulen->update(['is_published' => 1]);

    return response()->json([
        'success' => true,
        'message' => '✅ Notulen berhasil dipublish, semua undangan sekarang dapat melihat.'
    ]);
}
}