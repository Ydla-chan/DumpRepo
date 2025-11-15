<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'title',
        'date',
        'creator_id',
    ];

    // 🟢 Tambahkan relasi ini
    public function discussionPoints()
    {
        return $this->hasMany(DiscussionPoint::class);
    }

    // (opsional) relasi tambahan
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
