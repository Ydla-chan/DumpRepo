<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'backlog_id',
        'pic_id',
        'pekerjaan',
        'deadline',
        'progress',
        'status'
    ];

    // Task milik satu backlog
    public function backlog()
    {
        return $this->belongsTo(Backlog::class);
    }

    // PIC yang mengerjakan task
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}
