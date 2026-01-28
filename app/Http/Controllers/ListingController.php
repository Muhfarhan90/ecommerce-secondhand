<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    // Halaman utama
    public function index(Request $request)
    {
        $query = Listing::with(['category', 'images'])->where('status', 'active');

        // Search keyword
        if ($request->q) {
            $query->where(
                'title',
                'like',
                '%' . $request->q . '%'
            );
        }
        // Filter category
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $listings = $query
            ->latest('published_at')
            ->paginate(12);

        return view('listings.index', compact('listings'));
    }

    public function show(Listing $listing)
    {
        $listing->increment('views_count');

        return view('listings.show', compact('listing'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('listings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric',
            'condition' => 'required|in:new,used',
            'description' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'images.*' => 'required|image|max:2048',
        ]);

        $listing = Listing::create([
            'user_id' => auth()->id(),
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . time(),
            'description' => $data['description'],
            'price' => $data['price'],
            'condition' => $data['condition'],
            'status' => 'active',
            'city' => $data['city'],
            'province' => $data['province'],
            // sementara default, nanti bisa pakai GPS
            'latitude' => -7.250445,
            'longitude' => 112.768845,
            'published_at' => now(),
        ]);

        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('listings', 'public');

                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => '/storage/' . $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Iklan berhasil dipasang!');
    }

    public function edit(Listing $listing)
    {
        // Cek kepemilikan
        abort_if($listing->user_id !== auth()->id(), 403);

        $categories = Category::all();

        return view('listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, Listing $listing)
    {
        abort_if($listing->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric',
            'condition' => 'required|in:new,used',
            'description' => 'required|string',
            'city' => 'required',
            'province' => 'required',
        ]);

        $listing->update($data);

        return redirect()
            ->route('listings.show', $listing)
            ->with('success', 'Iklan berhasil diperbarui');
    }

    public function destroy(Listing $listing)
    {
        abort_if($listing->user_id !== auth()->id(), 403);

        $listing->delete();

        return redirect('/')
            ->with('success', 'Iklan berhasil dihapus');
    }
}
