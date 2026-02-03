<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display the seller's public profile page
     */
    public function show(User $user)
    {
        // Get seller's active listings
        $listings = $user->listings()
            ->with(['category', 'images'])
            ->where('status', 'active')
            ->latest('published_at')
            ->paginate(12);

        // Statistics
        $stats = [
            'total_listings' => $user->listings()->where('status', 'active')->count(),
            'total_views' => $user->listings()->sum('views_count'),
        ];

        return view('sellers.show', compact('user', 'listings', 'stats'));
    }
}
