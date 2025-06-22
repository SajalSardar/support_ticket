<?php

namespace App\Policies;

use App\Models\RequesterType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequesterTypePolicy {
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        if ($user->can('requestertype view list')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RequesterType $requesterType): bool {
        if ($user->can('requestertype view list')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        //
        return ($user->can('requestertype create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RequesterType $requesterType): bool {
        if ($user->can('requestertype update')) {
            return true;
        }
        return false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RequesterType $requesterType): bool {
        if ($user->can('requestertype delete')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RequesterType $requesterType): bool {
        if ($user->can('requestertype restore')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RequesterType $requesterType): bool {
        if ($user->can('requestertype force delete')) {
            return true;
        }
        return false;
    }
}
