<?php

namespace App\Policies;

use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketStatusPolicy {
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        if ($user->can('requeststatus view list')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TicketStatus $ticketStatus): bool {
        if ($user->can('requeststatus view list')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        //
        return ($user->can('requeststatus create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TicketStatus $ticketStatus): bool {
        if ($user->can('requeststatus update')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TicketStatus $ticketStatus): bool {
        if ($user->can('requeststatus delete')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TicketStatus $ticketStatus): bool {
        if ($user->can('requeststatus restore')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TicketStatus $ticketStatus): bool {
        if ($user->can('requeststatus force delete')) {
            return true;
        }
        return false;
    }
}
