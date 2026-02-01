<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MyListingController extends Controller
{
    /**
     * Display authenticated user's listings
     */
    public function index(Request $request)
    {
        $query = Listing::with(['category', 'images'])
            ->where('user_id', auth()->id());

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search in own listings
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $listings = $query->latest('created_at')->paginate(12);

        // Statistics
        $stats = [
            'total' => Listing::where('user_id', auth()->id())->count(),
            'active' => Listing::where('user_id', auth()->id())->where('status', 'active')->count(),
            'inactive' => Listing::where('user_id', auth()->id())->where('status', 'inactive')->count(),
            'total_views' => Listing::where('user_id', auth()->id())->sum('views_count'),
        ];

        return view('my-listings.index', compact('listings', 'stats'));
    }

    /**
     * Show the form for creating a new listing
     */
    public function create()
    {
        $categories = Category::all();

        return view('my-listings.create', compact('categories'));
    }

    /**
     * Store a newly created listing
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,used',
            'description' => 'required|string|min:20',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Create listing
        $listing = Listing::create([
            'user_id' => auth()->id(),
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . time(),
            'description' => $data['description'],
            'price' => $data['price'],
            'condition' => $data['condition'],
            'city' => $data['city'],
            'province' => $data['province'],
            'address' => $data['address'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'status' => 'active',
            'published_at' => now(),
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('listings', 'public');

                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => '/storage/' . $path,
                    'is_primary' => $index === 0, // First image is primary
                ]);
            }
        }

        return redirect()
            ->route('listings.show', $listing)
            ->with('success', 'Iklan berhasil dipasang!');
    }

    /**
     * Show the form for editing the specified listing
     */
    public function edit(Listing $listing)
    {
        // Authorization check
        abort_if($listing->user_id !== auth()->id(), 403);

        $categories = Category::all();

        return view('my-listings.edit', compact('listing', 'categories'));
    }

    /**
     * Update the specified listing
     */
    public function update(Request $request, Listing $listing)
    {
        // Authorization check
        abort_if($listing->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,used',
            'description' => 'required|string|min:20',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update slug if title changed
        if ($data['title'] !== $listing->title) {
            $data['slug'] = Str::slug($data['title']) . '-' . time();
        }

        $listing->update($data);

        // Handle new images if uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');

                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => '/storage/' . $path,
                ]);
            }
        }

        return redirect()
            ->route('listings.show', $listing)
            ->with('success', 'Iklan berhasil diperbarui!');
    }

    /**
     * Remove the specified listing
     */
    public function destroy(Listing $listing)
    {
        // Authorization check
        abort_if($listing->user_id !== auth()->id(), 403);

        // Change status to inactive (soft delete)
        $listing->update(['status' => 'inactive']);

        return redirect()
            ->route('my-listings.index')
            ->with('success', 'Iklan berhasil dihapus!');
    }

    /**
     * Toggle listing status (active/inactive)
     */
    public function toggleStatus(Listing $listing)
    {
        abort_if($listing->user_id !== auth()->id(), 403);

        $newStatus = $listing->status === 'active' ? 'inactive' : 'active';
        $listing->update(['status' => $newStatus]);

        return back()->with('success', 'Status iklan berhasil diubah!');
    }

    /**
     * Delete a specific listing image
     */
    public function deleteImage(ListingImage $image)
    {
        $listing = $image->listing;

        // Authorization check
        abort_if($listing->user_id !== auth()->id(), 403);

        // Prevent deleting if it's the only image
        if ($listing->images()->count() <= 1) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus foto terakhir'], 422);
        }

        // Delete file from storage
        $imagePath = str_replace('/storage/', '', $image->image_path);
        if (\Storage::disk('public')->exists($imagePath)) {
            \Storage::disk('public')->delete($imagePath);
        }

        // If deleting primary image, set another as primary
        if ($image->is_primary) {
            $newPrimary = $listing->images()->where('id', '!=', $image->id)->first();
            if ($newPrimary) {
                $newPrimary->update(['is_primary' => true]);
            }
        }

        $image->delete();

        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus']);
    }
}
