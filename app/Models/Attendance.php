<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'rapat_id',
        'user_id',
        'name',
        'email',
        'scanned_at',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
