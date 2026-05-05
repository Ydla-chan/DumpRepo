<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
    use HasFactory;

    protected $fillable = [
        'rapat_id',
        'judul',
        'tanggal',
        'pembuat_id',
        'is_published',
        'ringkasan',
        'ringkasan_generated_at',
    ];

    // 🟢 Tambahkan relasi ini
    public function pokokBahasans()
    {
        return $this->hasMany(PokokBahasan::class);
    }

    // (opsional) relasi tambahan
    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }

    /**
     * Generate ringkasan otomatis dari notulen
     */
    public function generateRingkasan()
    {
        $pokokBahasans = $this->pokokBahasans()->with('keputusans.tindakans.pic')->get();
        
        if ($pokokBahasans->isEmpty()) {
            return null;
        }

        $ringkasan = "📋 RINGKASAN NOTULEN: " . $this->judul . "\n";
        $ringkasan .= "📅 Tanggal: " . \Carbon\Carbon::parse($this->tanggal)->format('d-m-Y') . "\n";
        $ringkasan .= "================================\n\n";

        $no = 1;
        foreach ($pokokBahasans as $pb) {
            $ringkasan .= "🔹 POKOK BAHASAN {$no}: " . $pb->judul . "\n";
            
            if ($pb->deskripsi) {
                $ringkasan .= "   └─ " . substr($pb->deskripsi, 0, 150);
                if (strlen($pb->deskripsi) > 150) {
                    $ringkasan .= "...";
                }
                $ringkasan .= "\n";
            }

            if ($pb->keputusans->isNotEmpty()) {
                $ringkasan .= "\n   📌 KEPUTUSAN:\n";
                foreach ($pb->keputusans as $k) {
                    $ringkasan .= "      • " . $k->isi_keputusan . "\n";

                    if ($k->tindakans->isNotEmpty()) {
                        $ringkasan .= "        TINDAKAN LANJUT:\n";
                        foreach ($k->tindakans as $t) {
                            $pic_name = $t->pic ? $t->pic->name : 'Tidak ditentukan';
                            $deadline = $t->deadline ? \Carbon\Carbon::parse($t->deadline)->format('d-m-Y') : 'Tidak ada';
                            $ringkasan .= "        ✓ {$t->deskripsi} (PIC: {$pic_name}, Deadline: {$deadline})\n";
                        }
                    }
                }
            }

            $ringkasan .= "\n";
            $no++;
        }

        return $ringkasan;
    }
}