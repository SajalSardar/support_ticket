<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TicketPolicy {
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        if ($user->can('request view list')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool {
        if ($user->can('request view list')) {
            return !Auth::user()->hasRole(['requester', 'Requester']) || $ticket->user_id == Auth::id();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        //
        return ($user->can('request create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool {
        if ($user->can('request update')) {
            return !Auth::user()->hasRole(['requester', 'Requester']) || $ticket->user_id == Auth::id();
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool {
        if ($user->can('request delete')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool {
        if ($user->can('request restore')) {
            return true;
        }
        if ($user->can('request force delete')) {
            return true;
        }
        return false;
    }

}
