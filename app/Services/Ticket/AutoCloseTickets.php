<?php

namespace App\Services\Ticket;

use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketNote;
use App\Models\TicketStatus;
use Carbon\Carbon;

class AutoCloseTickets {

    public function __construct() {
        $this->requestClose();
    }

    public function requestClose() {
        $threshold = Carbon::now()->subHours(72);

        $resolvedStatus = TicketStatus::where('slug', 'resolved')->first();
        $closedStatus   = TicketStatus::where('slug', 'closed')->first();

        if ($resolvedStatus && $closedStatus) {
            $tickets = Ticket::where('ticket_status_id', $resolvedStatus->id)
                ->whereNotNull('resolved_at')
                ->where('resolved_at', '<=', $threshold)
                ->get();

            foreach ($tickets as $ticket) {
                $ticket->ticket_status_id = $closedStatus->id;
                $ticket->save();

                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'status_change',
                        'note'       => 'System auto closed request!',
                        'old_status' => 'resolved',
                        'new_status' => 'closed',
                        'created_by' => 1,
                    ]
                );

                TicketLog::create(
                    [
                        'ticket_id'     => $ticket->id,
                        'ticket_status' => 'closed',
                        'status'        => 'updated',
                        'comment'       => 'System auto closed request!',
                        'updated_by'    => 1,
                        'created_by'    => 1,
                    ]
                );

            }
        }
    }
}
