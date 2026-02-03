<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove /storage/ prefix from existing banner image paths
        DB::table('banners')->get()->each(function ($banner) {
            if (str_starts_with($banner->image_path, '/storage/')) {
                DB::table('banners')
                    ->where('id', $banner->id)
                    ->update(['image_path' => substr($banner->image_path, 9)]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add /storage/ prefix back
        DB::table('banners')->get()->each(function ($banner) {
            if (!str_starts_with($banner->image_path, '/storage/')) {
                DB::table('banners')
                    ->where('id', $banner->id)
                    ->update(['image_path' => '/storage/' . $banner->image_path]);
            }
        });
    }
};
