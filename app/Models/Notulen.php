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
}
