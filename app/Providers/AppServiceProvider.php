<?php

namespace App\Providers;

use App\Models\Listing;
use App\Policies\ListingPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(Listing::class, ListingPolicy::class);

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
