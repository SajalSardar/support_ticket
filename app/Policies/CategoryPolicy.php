<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy {
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        if ($user->can('category view list')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool {
        if ($user->can('category view list')) {
            return true;
        }
        return false;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        //
        return ($user->can('category create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool {
        if ($user->can('category update')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool {
        if ($user->can('category delete')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool {
        if ($user->can('category restore')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool {
        if ($user->can('category force delete')) {
            return true;
        }
        return false;
    }
}
