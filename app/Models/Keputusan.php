<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keputusan extends Model
{
    use HasFactory;

    protected $fillable = ['pokok_bahasan_id', 'isi_keputusan'];

    public function pokokBahasan()
    {
        return $this->belongsTo(PokokBahasan::class);
    }

    public function tindakans()
    {
        return $this->hasMany(Tindakan::class);
    }
}
