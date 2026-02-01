<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'condition',
        'status',
        'latitude',
        'longitude',
        'address',
        'city',
        'province',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
    public function views()
    {
        return $this->hasMany(ListingView::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
