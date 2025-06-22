<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Bucket;
use App\Http\Controllers\Controller;
use App\LocaleStorage\Fileupload;
use App\Mail\LogUpdateMail;
use App\Mail\TicketEmail;
use App\Mail\UpdateInfoMail;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Department;
use App\Models\Image;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\TicketOwnership;
use App\Models\TicketStatus;
use App\Models\User;
use App\Services\Ticket\TicketService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Define public property $requester_type;
     * @var array|object
     */
    public $requester_type;

    /**
     * Define public property $sources;
     * @var array|object
     */
    public $sources;

    /**
     * Define public property $categories;
     * @var array|object
     */
    public $categories;

    /**
     * Define public property $teams;
     * @var array|object
     */
    public $teams;

    /**
     * Define public property $ticket_status;
     * @var array|object
     */
    public $ticket_status;

    /**
     * Define public property $agents;
     * @var array|object
     */
    public $teamAgent;

    /**
     * Define public property $ticket
     */
    public $ticket;

    /**
     * Define public property $tickets
     * @var array|object
     */
    public array | object $tickets = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Ticket::class);

        $this->tickets = Cache::remember('status_' . Auth::id() . '_ticket_list', 60 * 60, function () {
            return TicketStatus::query()
                ->with('ticket', function ($query) {
                    $query->with(['owners', 'source', 'user', 'team'])
                        ->orderBy('id', 'desc')
                        ->take(10);
                })
                ->orderByRaw("CASE WHEN ticket_statuses.name = 'open' THEN 1 ELSE 2 END")
                ->orderBy('ticket_statuses.name')
                ->get();
        });

        return view("ticket.index", ['tickets' => $this->tickets ?? collect()]);
    }

    public function allTicketList()
    {
        Gate::authorize('viewAny', Ticket::class);
        $queryStatus  = request()->get('request_status') ?? null;
        $categories   = Category::where('status', 1)->get();
        $teams        = Team::where('status', 1)->get();
        $ticketStatus = TicketStatus::where('status', 1)->get();
        $departments  = Department::where('status', true)->get();
        return view('ticket.all_list', compact('queryStatus', 'categories', 'teams', 'ticketStatus', 'departments'));
    }

    /**
     * Define all ticket list datatable
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function allTicketListDataTable(Request $request)
    {
        Gate::authorize('viewAny', Ticket::class);
        return TicketService::allTicketListDataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Ticket::class);
        return view('ticket.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Ticket $ticket)
    {
        if ($request->ajax()) {
            $agents = Team::query()->with('agents')->where('id', $request->team_id)->get();
            return response()->json($agents);
        }
        Gate::authorize('view', $ticket);

        $notiryId = request()->has('notify_id') ? request()->get('notify_id') : null;

        if ($notiryId) {
            TicketNote::where('id', $notiryId)->update([
                'view_notification' => true,
            ]);
        }

        $requester_type = RequesterType::query()->get();
        $sources        = Source::query()->get();
        $teams          = Team::query()->get();
        $categories     = Category::where('parent_id', null)->get();
        $ticket_status  = TicketStatus::query()->get();
        $agents         = Team::query()->with('agents')->where('id', $ticket?->team_id)->get();
        $users          = User::whereNotIn('id', [1])->select('id', 'name', 'email')->get();
        $departments    = Department::where('status', true)->get();

        $ticket = Ticket::where('id', $ticket->id)
            ->with([
                'ticket_notes' => function ($q) {
                    $q->orderBy('id', 'desc');
                },
                'conversation' => function ($q) {
                    $q->orderBy('created_at', 'desc');
                },
                'conversation.creator',
                'conversation.replay',
                'ticket_notes.creator',
                'images',
            ])
            ->first();

        $conversations = $ticket->conversation->where('parent_id', null)->groupBy(function ($query) {
            return date('Y m d', strtotime($query->created_at));
        });

        $histories     = $ticket->ticket_notes->whereNotIn('note_type', ['internal_note']);
        $internalNotes = $ticket->ticket_notes->where('note_type', 'internal_note');

        $data = [
            'ticket'         => $ticket,
            'requester_type' => $requester_type,
            'sources'        => $sources,
            'teams'          => $teams,
            'categories'     => $categories,
            'ticket_status'  => $ticket_status,
            'agents'         => $agents,
            'users'          => $users,
            'conversations'  => $conversations,
            'histories'      => $histories,
            'departments'    => $departments,
            'internalNotes'  => $internalNotes,
        ];
        return view('ticket.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Ticket $ticket
     */
    public function edit(Ticket $ticket)
    {
        Gate::authorize('update', $ticket);
        if ($ticket->ticket_status->slug == 'closed' || $ticket->ticket_status->slug == 'resolved') {
            flash()->info('Ticket has been closed or resolved');
            return back();
        }
        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        Gate::authorize('delete', $ticket);
        $ticket->delete();
        flash()->success('Ticket has been trashed');
        return back();
    }

    public function bulkDelete(Request $request)
    {

        Gate::authorize('delete', Ticket::class);
        foreach ($request->request_ids as $request_id) {
            Ticket::where('id', $request_id)->delete();
        }
        flash()->success('Ticket has been trashed');
        return back();
    }

    public function trashRequestList()
    {
        Gate::authorize('restore', Ticket::class);
        $categories   = Category::where('status', 1)->get();
        $teams        = Team::where('status', 1)->get();
        $ticketStatus = TicketStatus::where('status', 1)->get();
        $departments  = Department::where('status', true)->get();
        return view('ticket.trash', compact('categories', 'teams', 'ticketStatus', 'departments'));
    }

    public function trashRequestDatatable(Request $request)
    {
        Gate::authorize('restore', Ticket::class);
        return TicketService::trashTicketListDataTable($request);
    }

    public function restoreTrashRequest($ticket)
    {
        Gate::authorize('restore', Ticket::class);

        $tickets = Ticket::where('id', $ticket)->onlyTrashed()->restore();
        flash()->success('Ticket has been restored');
        return back();
    }

    public function deleteTrashRequest($ticket)
    {
        Gate::authorize('forceDelete', Ticket::class);
        $ticket = Ticket::with('ticket_notes', 'ticket_logs')->where('id', $ticket)->onlyTrashed()->first();
        $ticket->ticket_notes()->forceDelete();
        $ticket->ticket_logs()->forceDelete();
        $ownership = TicketOwnership::where('ticket_id', $ticket->id)->forceDelete();
        $ticket->forceDelete();
        flash()->success('Ticket has been permanently deleted!');
        return back();
    }

    public function trashBluckRequestDeleteRestore(Request $request)
    {
        Gate::authorize('restore', Ticket::class);
        if ($request->bluck_action_type === 'restore') {
            foreach ($request->request_ids as $request_id) {
                Ticket::where('id', $request_id)->onlyTrashed()->restore();
            }
        } elseif ($request->bluck_action_type === 'delete') {
            foreach ($request->request_ids as $request_id) {
                Ticket::where('id', $request_id)->forceDelete();
            }
        }

        flash()->success('Action completed successfully!');
        return back();
    }

    /**
     * Delete file of the model
     * @param Ticket $ticket
     * @return mixed
     */
    public function trashFile(string $id)
    {
        $response = Image::find($id);
        $response->delete();
        flash()->success('File has been deleted');
        return back();
    }

    /**
     * Define public method logUpdate() to update log of ticket
     * @param Request $request
     */
    public function logUpdate(Request $request, Ticket $ticket)
    {

        $request->validate([
            "team_id"          => 'required',
            "category_id"      => 'required',
            "ticket_status_id" => 'required',
            "priority"         => 'required',
            "comment"          => 'required',
            "department_id"    => 'required',
        ]);
        $emailResponse = null;

        DB::beginTransaction();
        try {
            $ticket_status = TicketService::getTicketStatusById($ticket->ticket_status_id);

            $emailResponse = TicketService::ticketChangesNote($request, $ticket, $ticket_status);

            $ticket->update(
                [
                    'priority'         => $request->priority,
                    'due_date'         => $request->due_date,
                    'team_id'          => $request->team_id,
                    'category_id'      => $request->category_id,
                    'sub_category_id'  => $request->sub_category_id,
                    'ticket_status_id' => $request->ticket_status_id,
                    'department_id'    => $request->department_id,
                    'updated_by'       => Auth::id(),
                ]
            );

            TicketService::createTicketLog($ticket->getKey(), $ticket_status->name, 'updated', json_encode($ticket));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            TicketService::createTicketLog($ticket->getKey(), $ticket_status->name, 'update_fail', json_encode($e->getMessage()));
        }

        if (!empty($emailResponse)) {
            Mail::to($ticket->user->email)->queue(new LogUpdateMail($emailResponse));
        }
        flash()->success('Data has been updated successfully');
        return back();
    }

    /**
     * Define public method interNoteStore() to add internal notes
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function interNoteStore(Request $request, Ticket $ticket): RedirectResponse
    {
        $request->validate([
            "internal_note" => 'required',
        ]);
        $ticket_status = TicketService::getTicketStatusById($ticket->ticket_status_id);
        $internal_note = TicketService::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'internal_note', $request->internal_note);
        $internal_note ? flash()->success('Internal Note has been Added!') : flash()->success('Something went wrong !!!');
        return back();
    }

    /**
     * Define public method to download the file.
     * @param Image $file
     * @return mixed|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFile(Image $file)
    {
        $filePath = public_path(parse_url($file->url, PHP_URL_PATH));
        return response()->download($filePath);
    }

    /**
     * Method for change the owner of ticket
     * @param Request $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function ticketRequesterChange(Request $request, Ticket $ticket): RedirectResponse
    {
        $checkUser = User::query()->where('email', $request->requester_email)->first();
        if (!empty($checkUser)) {
            $request->merge([
                'credentials' => false,
            ]);

            $checkUser->update(
                [
                    'phone'             => $request->requester_phone,
                    'name'              => $request->requester_name,
                    'requester_type_id' => $request->requester_type_id,
                    'requester_id'      => $request->requester_id,
                ]
            );

            $ticket->update(
                [
                    'user_id' => $checkUser->id,
                ]
            );
        } else {

            $password = rand(10000000, 99999999);
            $request->merge([
                'credentials' => true,
                'password'    => $password,
            ]);

            $user = User::create([
                'name'              => $request?->requester_name,
                'email'             => $request?->requester_email,
                'phone'             => $request?->requester_phone,
                'password'          => Hash::make($password),
                'requester_type_id' => $request?->requester_type_id,
                'requester_id'      => $request?->requester_id,
            ]);

            $user->assignRole('requester');

            $ticket->update(
                [
                    'user_id' => $user->getKey(),
                ]
            );

            event(new Registered($user));
        }

        try {

            TicketService::createTicketNote($ticket->id, $ticket->ticket_note->old_status, $ticket->ticket_note->new_status, 'requester_change', $ticket->ticket_note->note);

            TicketService::createTicketLog($ticket->getKey(), $ticket->ticket_status->name, 'updated', json_encode($ticket));
        } catch (\Exception $e) {
            TicketService::createTicketLog($ticket->getKey(), $ticket->ticket_status->name, 'update_fail', json_encode($e->getMessage()));
        }

        Mail::to($request->requester_email)->send(new TicketEmail($request));
        flash()->success('Requester Has been added');
        return back();
    }

    /**
     * Define public method partialUpdate() to update partially the ticket
     * @param Request $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function partialUpdate(Request $request, Ticket $ticket): RedirectResponse
    {
        $request->validate([
            "request_title"      => 'required',
            "request_attachment" => 'nullable|mimes:png,jpg,pdf,docx,heic,jpeg',
        ]);
        $ticketUpdate = $ticket->update([
            'title'       => $request->request_title,
            'description' => $request->request_description,
            'source_id'   => $request->source_id,
        ]);

        $isUpload = $request->request_attachment ? Fileupload::uploadFile($request, Bucket::TICKET, $ticket->getKey(), Ticket::class) : '';

        try {
            TicketService::createTicketLog($ticket->getKey(), $ticket->ticket_status->name, 'updated', json_encode($ticketUpdate));
        } catch (\Exception $e) {
            TicketService::createTicketLog($ticket->getKey(), $ticket->ticket_status->name, 'update_fail', json_encode($e->getMessage()));
        }
        $source = Source::find($request->source_id);

        Mail::to($ticket->user->email)->queue(new UpdateInfoMail($ticket));
        flash()->success('Edit has been successfully done');
        return back();
    }

    public function categoryWiseSubcategory(Request $request)
    {
        // return $request->category_id;
        $subCategorys = Category::where('parent_id', $request->category_id)->where('status', 1)->get();

        return $subCategorys;
    }
    public function departmentWiseTeam(Request $request)
    {
        // return $request->category_id;
        $teams = Team::where('department_id', $request->department_id)->where('status', 1)->get();

        return $teams;
    }
}
