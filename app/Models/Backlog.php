<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backlog extends Model
{
    protected $fillable = [
        'rapat_id',
        'judul',
        'deskripsi',
        'status',
        'created_by'
    ];

    // Relasi → 1 Backlog punya banyak Tasks (Logbook)
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relasi → Backlog berasal dari Rapat/Notulen
    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }

    // Relasi → yang membuat backlog
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
