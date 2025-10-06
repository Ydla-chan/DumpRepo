<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // Table defaultnya "groups" sudah sesuai dengan konvensi Laravel

    // Kalau mau mass assignment untuk kolom tertentu
    protected $fillable = [
        'name',
    ];

    // Relasi ke User (satu group punya banyak user)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
