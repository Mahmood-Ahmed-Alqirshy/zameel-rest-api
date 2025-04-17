<?php

namespace App\Policies;

use App\Models\Teaching;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class TeachingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Gate::forUser($user)->any(['admin', 'manager']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Teaching $teaching):  bool
    {
        return Gate::forUser($user)->any(['admin', 'manager']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Gate::forUser($user)->any(['admin', 'manager']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Teaching $teaching): bool
    {
        return Gate::forUser($user)->any(['admin', 'manager']);
    }
}
