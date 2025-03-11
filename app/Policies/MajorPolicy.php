<?php

namespace App\Policies;

use App\Models\Major;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class MajorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Major $major): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Gate::forUser($user)->check('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Major $major): bool
    {
        return Gate::forUser($user)->check('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Major $major): bool
    {
        return Gate::forUser($user)->check('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Major $major): bool
    {
        return Gate::forUser($user)->check('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Major $major): bool
    {
        return Gate::forUser($user)->check('admin');
    }
}
