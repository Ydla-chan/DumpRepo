<?php

namespace App\Http\Controllers;

use App\Models\Rapat; 
use Illuminate\Http\Request;
use App\Models\Tindakan;
use Illuminate\Support\Facades\Auth;

class BacklogController extends Controller
{
    // ... (Metode index tidak perlu diubah) ...
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Ambil SEMUA tindakan (termasuk yang Selesai) untuk user ini
        $allTindakans = $user->tindakans()
            ->with([
                'keputusan.pokokBahasan.notulen.rapat',
            ])
            ->orderBy('deadline', 'asc')
            ->get();

        // 2. Kelompokkan Tindakan berdasarkan ID Rapat (atau 'lain-lain')
        $groupedTasks = $allTindakans->groupBy(function ($tindakan) {
            // Cek rantai relasi dengan aman
            if (optional(optional(optional($tindakan->keputusan)->pokokBahasan)->notulen)->rapat_id) {
                return $tindakan->keputusan->pokokBahasan->notulen->rapat_id;
            }
            // Fallback untuk tugas yang tidak punya rapat
            return 'lain-lain';
        });

        // 3. Ambil data Rapat untuk menampilkan judulnya
        $rapatIds = $groupedTasks->keys()->filter(fn($key) => is_numeric($key));
        $rapats = Rapat::whereIn('id', $rapatIds)->get()->keyBy('id'); // keyBy('id') untuk pencarian mudah

        // 4. Pastikan grup 'lain-lain' memiliki Rapat placeholder agar Blade tidak error.
        $rapats->put('lain-lain', (object)['judul' => 'Tugas Lain-lain', 'tanggal' => null]);
        
        $viewType = $request->get('view', 'kanban');
        
        $activeTasks = $allTindakans->where('status', '!=', 'done'); 

        // PENTING: Pastikan Anda merender view yang benar di sini.
        // Jika file Blade Anda bernama `my-backlog-kanban.blade.php`, 
        // Anda mungkin perlu ganti 'kanban' menjadi 'global.my-backlog-kanban' 
        // tergantung struktur folder Anda. Saya asumsikan ini benar.
        return view('kanban', compact('groupedTasks', 'rapats', 'user', 'viewType'));
    }


    /**
     * Update status tindakan (untuk Kanban).
     * @param Request $request
     * @param \App\Models\Tindakan $tindakan (Route Model Binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, Tindakan $tindakan)
    {
        // 1. Otorisasi
        if ($tindakan->pic_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Aksi tidak diizinkan. Anda bukan PIC dari tugas ini.'], 403);
        }
             if ($tindakan->status === 'done' && $newStatus !== 'done') {
            return response()->json([
                'success' => false,
                'message' => 'Tindakan yang sudah selesai tidak bisa diubah kembali.'
            ], 403);
        }

        // 2. Validasi
        $validated = $request->validate([
            // Nilai status harus berupa string dan hanya boleh salah satu dari tiga nilai ini
            'status' => 'required|string|in:pending,in_progress,done',
        ]);

        try {
            // 3. Perbarui Status - gunakan DB::statement untuk memastikan quoting yang benar
            $newStatus = $validated['status'];
            
            // Validasi ulang nilai enum
            if (!in_array($newStatus, ['pending', 'in_progress', 'done'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid'
                ], 422);
            }
            
            $tindakan->status = $newStatus;
            $tindakan->save();

            return response()->json([
                'success' => true, 
                'message' => 'Status berhasil diperbarui.',
                'new_status' => $tindakan->status // Kirim status terbaru untuk konfirmasi
            ]);

        } catch (\Exception $e) {
            // Catat error server
            \Log::error("Gagal update status tindakan ID {$tindakan->id}: " . $e->getMessage() . "\nStack: " . $e->getTraceAsString());

            return response()->json([
                'success' => false, 
                'message' => 'Gagal memperbarui status di server (Internal Error): ' . $e->getMessage(),
                'error_details' => $e->getMessage() // Hapus ini di lingkungan produksi!
            ], 500);
        }
    }
}