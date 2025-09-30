<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    public function likes()
    {
        return $this->hasMany(ThreadLike::class);
    }

    public function comments()
    {
        return $this->hasMany(ThreadComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $fillable = [
        'user_id',
        'content',
        'image',
        'likes_count',
        'comments_count',
    ];
}
