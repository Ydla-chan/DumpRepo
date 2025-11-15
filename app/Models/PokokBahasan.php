<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokokBahasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'minute_id',
        'title',
        'description',
    ];

    public function minute()
    {
        return $this->belongsTo(Notulen::class);
    }

    public function decisions()
    {
        return $this->hasMany(Decision::class);
    }
}
