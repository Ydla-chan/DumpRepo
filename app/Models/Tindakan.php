<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;

    protected $fillable = ['keputusan_id', 'pic_id', 'deskripsi', 'deadline', 'status'];

    public function keputusan()
    {
        return $this->belongsTo(Keputusan::class);
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}
