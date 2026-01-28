<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'icon'];

    // Kategori punya banyak listing
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
