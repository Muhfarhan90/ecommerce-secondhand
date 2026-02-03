<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Listing;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_listings' => Listing::count(),
            'active_listings' => Listing::where('status', 'active')->count(),
            'total_categories' => Category::count(),
            'total_banners' => Banner::count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_listings = Listing::with(['user', 'category'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_listings'));
    }
}
