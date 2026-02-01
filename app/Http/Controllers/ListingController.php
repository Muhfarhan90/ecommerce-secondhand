<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of listings with filters (PUBLIC)
     */
    public function index(Request $request)
    {
        $query = Listing::with(['category', 'images', 'user'])
            ->where('status', 'active');

        // Search keyword
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by condition
        if ($request->filled('condition') && $request->condition != '') {
            $query->where('condition', $request->condition);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->location . '%')
                    ->orWhere('province', 'like', '%' . $request->location . '%');
            });
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $listings = $query->paginate(12)->withQueryString();

        // Get categories for filter
        $categories = Category::withCount('listings')->get();

        return view('listings.index', compact('listings', 'categories'));
    }

    /**
     * Display the specified listing (PUBLIC)
     */
    public function show(Listing $listing, Request $request)
    {
        // Track unique views using session
        $sessionKey = 'listing_viewed_' . $listing->id;

        if (!$request->session()->has($sessionKey)) {
            // Increment view count only if not viewed in this session
            $listing->increment('views_count');
            // Mark as viewed for 24 hours
            $request->session()->put($sessionKey, now()->timestamp);
        }

        // Load relationships
        $listing->load(['category', 'images', 'user']);

        return view('listings.show', compact('listing'));
    }

    /**
     * Toggle favorite for authenticated user
     */
    public function toggleFavorite(Listing $listing)
    {
        $user = auth()->user();

        if ($user->favorites()->where('listing_id', $listing->id)->exists()) {
            $user->favorites()->detach($listing->id);
            $favorited = false;
        } else {
            $user->favorites()->attach($listing->id);
            $favorited = true;
        }

        return response()->json([
            'success' => true,
            'favorited' => $favorited
        ]);
    }
}
