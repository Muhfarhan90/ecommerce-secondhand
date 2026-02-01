<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
    /**
     * Determine if the user can view any listings
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the listing
     */
    public function view(?User $user, Listing $listing): bool
    {
        return $listing->status === 'active' || ($user && $user->id === $listing->user_id);
    }

    /**
     * Determine if the user can create listings
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the listing
     */
    public function update(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id;
    }

    /**
     * Determine if the user can delete the listing
     */
    public function delete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id;
    }

    /**
     * Determine if the user can restore the listing
     */
    public function restore(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id;
    }

    /**
     * Determine if the user can permanently delete the listing
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id;
    }
}
