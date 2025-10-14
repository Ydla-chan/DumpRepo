<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 


class Rapat extends Model
{
    use HasFactory;

    protected $table = 'rapats';

    protected $fillable = [
        'judul',
        'agenda',
        'tanggal',
        'jam',
        'undangan',
        'tipe_lokasi',
        'link',
        'ruangan',
    ];


  protected $casts = [
    'undangan' => 'array',
    'tanggal' => 'date',
    'jam' => 'string', // ✅ biar aman
];
public function notulen()
{
    return $this->hasOne(Notulen::class);
}
}