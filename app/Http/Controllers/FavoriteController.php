<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display authenticated user's favorited listings
     */
    public function index()
    {
        $userId = auth()->id();

        $favorites = Favorite::with(['listing.category', 'listing.images', 'listing.user'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }
}
