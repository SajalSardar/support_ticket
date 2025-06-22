<?php

namespace App\Policies;

use App\Models\TicketOwnership;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TicketOwnershipPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         if ($user->can('ticketOwnership view list')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TicketOwnership $ticketOwnership): bool
    {
        if ($user->can('ticketOwnership view list')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return ($user->can('ticketOwnership create'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TicketOwnership $ticketOwnership): bool
    {
        if ($user->can('ticketOwnership update')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TicketOwnership $ticketOwnership): bool
    {
        if ($user->can('ticketOwnership delete')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TicketOwnership $ticketOwnership): bool
    {
        if ($user->can('ticketOwnership restore')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TicketOwnership $ticketOwnership): bool
    {
        if ($user->can('ticketOwnership force delete')) {
            return true;
        }
        return false;
    }
}
