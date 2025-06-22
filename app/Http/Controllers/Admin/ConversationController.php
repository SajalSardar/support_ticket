<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ConversationMail;
use App\Mail\ReplayMail;
use App\Models\Conversation;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ConversationController extends Controller {

    /**
     * Define public method conversation() to store the conversation
     * @param Request $request
     * @param Ticket $ticket
     */
    public function conversation(Request $request, Ticket $ticket) {
        $conversation = Conversation::create([
            'ticket_id'         => $ticket->id,
            'requester_id'      => $ticket->user_id,
            'conversation_type' => 'customer',
            'conversation'      => $request->conversation,
            'status'            => 1,
            'created_by'        => Auth::id(),
        ]);
        Mail::to($ticket->user->email)->queue(new ConversationMail($conversation));
        flash()->success('Conversation has been added successfully');
        return back();
    }

    /**
     * Method for replay the conversation
     * @param Request $request
     * @param Conversation $conversation
     * @return RedirectResponse
     */
    public function replay(Request $request, Conversation $conversation): RedirectResponse {

        $replay = Conversation::create([
            'ticket_id'         => $conversation->ticket_id,
            'requester_id'      => $conversation->requester_id,
            'parent_id'         => $conversation->id,
            'conversation_type' => 'customer_type',
            'conversation'      => $request->conversation,
            'status'            => '1',
            'created_by'        => Auth::id(),
        ]);

        $ticket = Ticket::with('user')->where('id', $conversation->ticket_id)->first();
        Mail::to($ticket->user->email)->queue(new ReplayMail($request->conversation));
        flash()->success('Replay has been added');
        return back();
    }
}
