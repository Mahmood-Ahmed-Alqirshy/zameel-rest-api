<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class BookPolicy
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
    public function view(User $user, Book $book): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !Gate::forUser($user)->check('student');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Book $book): bool
    {
        return !Gate::forUser($user)->check('student');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Book $book): bool
    {
        return !Gate::forUser($user)->check('student');
    }
}
