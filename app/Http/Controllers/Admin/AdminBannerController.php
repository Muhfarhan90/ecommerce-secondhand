<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::with('listing.user')->orderBy('order')->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'listing_id' => 'nullable|exists:listings,id',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $data['image_path'] = $path;
        }

        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? 0;

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil ditambahkan');
    }

    public function edit(Banner $banner)
    {
        $banner->load('listing');
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'listing_id' => 'nullable|exists:listings,id',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Upload new image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $path = $request->file('image')->store('banners', 'public');
            $data['image_path'] = $path;
        }

        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? 0;

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil diperbarui');
    }

    public function destroy(Banner $banner)
    {
        // Delete image
        if ($banner->image_path) {
            $path = str_replace('/storage/', '', $banner->image_path);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus');
    }

    /**
     * AJAX endpoint to search listings for banner
     */
    public function searchListings(Request $request)
    {
        $search = $request->get('q', '');

        $listings = Listing::with(['user', 'images'])
            ->where('status', 'active')
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->limit(10)
            ->get()
            ->map(function ($listing) {
                return [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'seller' => $listing->user->name,
                    'price' => 'Rp ' . number_format($listing->price, 0, ',', '.'),
                    'thumbnail' => $listing->images->first()?->image_path ?? '/images/placeholder.png',
                ];
            });

        return response()->json($listings);
    }
}
