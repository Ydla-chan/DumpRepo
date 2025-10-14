<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokokBahasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'notulen_id',
        'judul',
        'deskripsi',
    ];

    public function notulen()
    {
        return $this->belongsTo(Notulen::class);
    }

    public function keputusans()
    {
        return $this->hasMany(Keputusan::class);
    }
}
