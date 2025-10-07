<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
    use HasFactory;

    protected $fillable = ['rapat_id', 'judul', 'tanggal', 'pembuat_id'];

    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }

    public function pokokBahasans()
    {
        return $this->hasMany(PokokBahasan::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }
}
