<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with featured listings
     */
    public function index(Request $request)
    {
        $query = Listing::with(['category', 'images', 'user'])
            ->where('status', 'active');

        // Search functionality
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Get featured or latest listings
        $listings = $query->latest('published_at')
            ->take(8)
            ->get();

        // Get active banners
        $banners = Banner::with('listing')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Popular categories with listing count
        $categories = Category::withCount('listings')
            ->having('listings_count', '>', 0)
            ->orderBy('listings_count', 'desc')
            ->take(6)
            ->get();

        // Statistics
        $stats = [
            'total_listings' => Listing::where('status', 'active')->count(),
            'total_users' => \App\Models\User::count(),
        ];

        return view('home', compact('listings', 'categories', 'stats', 'banners'));
    }
}
