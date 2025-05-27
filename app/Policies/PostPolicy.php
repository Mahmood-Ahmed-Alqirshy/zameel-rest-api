<?php

namespace App\Policies;

use App\Models\College;
use App\Models\Group;
use App\Models\Major;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PostPolicy
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
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        $taggableType = request()->taggable_type;
        $taggableId = request()->taggable_id;
        if (Gate::forUser($user)->check('admin')) {
            return true;
        } elseif ($taggableType === College::class) {
            $isManger = Gate::forUser($user)->check('manager');
            $isMangerOfCollege = $user->colleges()->wherePivot('college_id', $taggableId)->exists();

            return $isManger && $isMangerOfCollege;
        } elseif ($taggableType === Major::class) {
            $isManger = Gate::forUser($user)->check('manager');
            $majorsCollegeID = Major::find($taggableId)->college->id;
            $isMangerOfMajor = $user->colleges()->wherePivot('college_id', $majorsCollegeID)->exists();

            return $isManger && $isMangerOfMajor;
        } elseif ($taggableType === Group::class) {
            if (Gate::forUser($user)->check('representer')) {
                return $user->groups()->wherePivot('group_id', $taggableId)->wherePivot('is_representer', true)->exists();
            }

            if (Gate::forUser($user)->check('academic') || Gate::forUser($user)->check('manager')) {
                return $user->teachingGroups()->wherePivot('group_id', $taggableId)->wherePivot('subject_id', request()->subject_id)->exists();
            }

            return false;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return Gate::forUser($user)->check('admin') || ($user->id === $post->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
