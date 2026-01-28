<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();

        $items = [
            [
                'title' => 'iPhone 11 128GB Mulus',
                'price' => 6500000,
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
            ],
            [
                'title' => 'Sepeda Gunung Polygon',
                'price' => 2800000,
                'city' => 'Malang',
                'province' => 'Jawa Timur',
            ],
            [
                'title' => 'Laptop Asus Ryzen 5',
                'price' => 7200000,
                'city' => 'Sidoarjo',
                'province' => 'Jawa Timur',
            ],
        ];

        foreach ($items as $item) {
            $listing = Listing::create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
                'title' => $item['title'],
                'slug' => Str::slug($item['title']) . '-' . rand(100, 999),
                'description' => 'Barang kondisi normal, siap pakai, bisa nego.',
                'price' => $item['price'],
                'condition' => 'used',
                'status' => 'active',
                'latitude' => -7.250445,
                'longitude' => 112.768845,
                'city' => $item['city'],
                'province' => $item['province'],
                'published_at' => now(),
            ]);

            ListingImage::create([
                'listing_id' => $listing->id,
                'image_path' => '/placeholder.jpg',
                'is_primary' => true,
            ]);
        }
    }
}
