<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keputusan extends Model
{
    use HasFactory;

    protected $fillable = ['discussion_point_id', 'decision_text'];

    public function discussionPoint()
    {
        return $this->belongsTo(DiscussionPoint::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
