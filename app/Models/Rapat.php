<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 


class Rapat extends Model
{
    use HasFactory;

    protected $table = 'meetings';

    protected $fillable = [
        'title',
        'agenda',
        'date',
        'time',
        'invitation',
        'location_type',
        'meeting_link',
        'room',
    ];


  protected $casts = [
    'invitation' => 'array',
    'date' => 'date',
    'time' => 'string', // ✅ biar aman
];
public function minute()
{
    return $this->hasOne(Notulen::class);
}
}