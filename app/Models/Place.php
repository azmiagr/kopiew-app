<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;
use App\Models\Wishlist;
use App\Models\Review;

class Place extends Model
{

    protected $fillable = ['user_id', 'name', 'address', 'description', 'operating_hours'];

    use HasFactory;
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
