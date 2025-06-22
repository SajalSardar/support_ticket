<?php

namespace App\Services\Ticket;

use App\Mail\LogUpdateMail;
use App\Mail\TicketEmail;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketNote;
use App\Models\TicketOwnership;
use App\Models\TicketStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use Yajra\DataTables\Facades\DataTables;

class TicketService
{
    /**
     * Define public property $user;
     * @var array|object
     */
    public $user = [];

    /**
     * Define public property $password;
     * @var string
     */
    public $password;

    /**
     * Define public method store to save the resource
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object
    {
        $checkUser = User::query()->where('email', $request->requester_email)->first();
        if (!empty($checkUser)) {
            $request->credentials = false;
            $checkUser->update(
                [
                    'phone'             => $request->requester_phone,
                    'name'              => $request->requester_name,
                    'requester_type_id' => $request->requester_type_id,
                    'requester_id'      => $request->requester_id,
                ]
            );
        } else {
            $this->password       = rand(10000000, 99999999);
            $request->credentials = true;
            $request->password    = $this->password;
            $this->user           = User::create([
                'name'              => $request?->requester_name,
                'email'             => $request?->requester_email,
                'phone'             => $request?->requester_phone,
                'password'          => Hash::make($this->password),
                'requester_type_id' => $request?->requester_type_id,
                'requester_id'      => $request?->requester_id,
            ]);
            $this->user->assignRole('requester');
            event(new Registered($this->user));
        }

        $response = Ticket::create(
            [
                'user_id'          => $checkUser ? $checkUser->id : $this->user->id,
                'department_id'    => $request?->department_id,
                'team_id'          => $request?->team_id,
                'category_id'      => $request?->category_id,
                'ticket_status_id' => $request?->ticket_status_id,
                'source_id'        => $request?->source_id,
                'title'            => $request?->request_title,
                'description'      => $request?->request_description,
                'priority'         => $request?->priority,
                'ticket_type'      => 'customer',
                'due_date'         => $request?->due_date,
                'created_by'       => $request->created_by ? $request->created_by : Auth::id(),
                'sub_category_id'  => $request?->sub_category_id,
            ]
        );

        $ticketStatus = $this->getTicketStatusById($request?->ticket_status_id);
        $this->createTicketNote($response->getKey(), $ticketStatus?->name, $ticketStatus?->name, 'request_assigned', $request?->request_title);
        $this->createTicketLog($response->getKey(), $ticketStatus->name, 'create', json_encode($response));
        if ($request->owner_id) {
            $response->owners()->attach($request->owner_id);
        }
        // dd($response->getKey());
        Mail::to($request->requester_email)->queue(new TicketEmail(ticket: $request, id: $response->getKey()));

        return $response;
    }

    /**
     * Define public method update to update the resource
     * @param Model $model
     * @param $request
     * @return array|object|bool
     */
    public function update(Model $model, $request)
    {

        $ticket        = Ticket::with('owners')->where('id', $model->getKey())->first();
        $requester     = User::where('email', $request->requester_email)->first();
        $emailResponse = null;
        DB::beginTransaction();
        try {
            if (!empty($requester)) {
                $requester->update(
                    [
                        'phone'             => $request->requester_phone,
                        'name'              => $request->requester_name,
                        'requester_type_id' => $request->requester_type_id,
                        'requester_id'      => $request->requester_id,
                    ]
                );
            }

            $ticket_status = $this->getTicketStatusById($ticket?->ticket_status_id);
            $emailResponse = $this->ticketChangesNote($request, $ticket, $ticket_status);

            $ticket->update(
                [
                    'department_id'    => $request?->department_id,
                    'source_id'        => $request->source_id,
                    'title'            => $request->request_title,
                    'description'      => $request->request_description,
                    'priority'         => $request->priority,
                    'due_date'         => $request->due_date,
                    'team_id'          => $request->team_id,
                    'category_id'      => $request->category_id,
                    'ticket_status_id' => $request->ticket_status_id,
                    'updated_by'       => Auth::id(),
                    'sub_category_id'  => $request?->sub_category_id,
                ]
            );

            $this->createTicketLog($ticket->getKey(), $ticket_status->name, 'updated', json_encode($ticket));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->createTicketLog($ticket->getKey(), $ticket_status->name, 'update_fail', json_encode($e->getMessage()));
        }

        if (!empty($emailResponse)) {
            Mail::to($ticket->user->email)->queue(new LogUpdateMail($emailResponse));
        }

        return $ticket;
    }

    public static function createTicketNote($ticketId, $old_status = null, $new_status = null, $note_type, $note = null)
    {
        $note = TicketNote::create(
            [
                'ticket_id'  => $ticketId,
                'note_type'  => $note_type,
                'note'       => $note,
                'old_status' => $old_status,
                'new_status' => $new_status,
                'created_by' => Auth::id(),
            ]
        );

        return $note;
    }
    public static function createTicketLog($ticketId, $ticket_status, $status = null, $comment = null)
    {
        $log = TicketLog::create(
            [
                'ticket_id'     => $ticketId,
                'ticket_status' => $ticket_status,
                'status'        => $status,
                'comment'       => $comment,
                'updated_by'    => Auth::id(),
                'created_by'    => Auth::id(),
            ]
        );

        return $log;
    }

    public static function getTicketStatusById($id)
    {
        $ticketStatus = TicketStatus::where('id', $id)->first();
        if ($ticketStatus) {

            return $ticketStatus;
        }
        return "Status Not Found!";
    }

    public static function ticketChangesNote($request, $ticket, $ticket_status)
    {

        $emailResponse = [];
        if ($request->owner_id && ($ticket->owners->isEmpty() || $ticket->owners->last()->id != $request->owner_id)) {

            $last_owner = TicketOwnership::where('ticket_id', $ticket->id)->where('duration', null)->orderBy('id', 'desc')->first();
            if ($last_owner && $request->owner_id) {
                $now                 = Carbon::now();
                $duration_in_seconds = $last_owner->created_at->diffInSeconds($now);
                $last_owner->update([
                    'duration' => $duration_in_seconds,
                ]);
            }

            $ticket->owners()->attach($request->owner_id);
            $note = $request->comment ? $request->comment : 'Owner changed';

            self::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'owner_change', $note);

            $emailResponse['owner_change'] = 'Owner changed';
        }
        if ($ticket->team_id != $request->team_id) {
            $note = $request->comment ? $request->comment : 'Team changed';
            self::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'team_change', $note);
            $emailResponse['team_change'] = 'Team changed';
        }
        if ($ticket->category_id != $request->category_id) {
            $note = $request->comment ? $request->comment : 'Category changed';
            self::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'category_change', $note);

            $emailResponse['category_change'] = 'Category changed';
        }
        if ($ticket->priority != $request->priority) {
            $note = $request->comment ? $request->comment : 'Priority changed';
            self::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'priority_change', $note);
            $emailResponse['priority'] = 'Priority changed';
        }

        $old_due_date = $ticket->due_date ? $ticket->due_date->format('Y-m-d') : '';
        if (empty($old_due_date) || $old_due_date != $request->due_date) {
            $note = $request->comment ? $request->comment : 'Due Date changed';
            self::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'due_date_change', $note);

            $emailResponse['due_date_change'] = 'Due date changed';
        }
        if ($ticket->ticket_status_id != $request->ticket_status_id) {

            $checkTicketStatus = self::getTicketStatusById($request->ticket_status_id);

            if ((ticketOpenProgressHoldPermission($request->ticket_status_id) == false) && $ticket->resolved_at == null) {
                $resolution_now        = Carbon::now();
                $resolution_in_seconds = $ticket->created_at->diffInSeconds($resolution_now);
                $ticket->update([
                    'resolution_time' => (int) $resolution_in_seconds,
                    'resolved_at'     => now(),
                    'resolved_by'     => Auth::id(),
                ]);
            }

            if (ticketOpenProgressHoldPermission($request->ticket_status_id) == true) {
                $ticket->update([
                    'resolution_time' => null,
                    'resolved_at'     => null,
                    'resolved_by'     => null,
                ]);
            }
            $note = $request->comment ? $request->comment : 'Status changed';
            self::createTicketNote($ticket->id, $ticket->ticket_status->name, $checkTicketStatus->name, 'status_change', $note);

            $emailResponse['status_change'] = 'Status changed';
        }

        if ($ticket->department_id != $request->department_id) {
            $note = $request->comment ? $request->comment : 'Department changed';
            self::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'department_change', $note);

            $emailResponse['department_change'] = 'Department changed';
        }

        return $emailResponse;
    }

    public static function allTicketListDataTable($request)
    {
        $ticketStatus = null;

        if ($request->query_status != 'unassign') {
            $ticketStatus = TicketStatus::where('slug', $request->query_status)->first();
        }

        $tickets = Ticket::query()
            ->with(['owners', 'source', 'user', 'team', 'category', 'sub_category', 'ticket_status', 'department']);

        if (Auth::user()->hasRole(['requester', 'Requester'])) {
            $tickets->where('user_id', Auth::id());
        }
        if (Auth::user()->hasRole(['agent', 'Agent'])) {
            // agent:view only own department request
            $user = User::with('teams')->where('id', Auth::id())->first();
            if ($user->hasAnyPermission(['agent:view only own department request'])) {
                $departments = $user->teams->pluck('department_id');
                $tickets->whereIn('department_id', $departments);
            }
        }

        if ($request->query_status == 'unassign') {

            $tickets->leftJoin('ticket_ownerships as owner', 'tickets.id', '=', 'owner.ticket_id')
                ->where('owner.owner_id', null)
                ->select('tickets.*', 'owner.owner_id');
        } elseif ($ticketStatus && $ticketStatus->slug == $request->query_status) {

            $tickets->where('ticket_status_id', $ticketStatus->id);
        }

        if ($request->all()) {
            $tickets->where(function ($query) use ($request, $tickets) {
                if ($request->me_mode_search) {
                    $query->whereHas('owners', function ($query) {
                        $query->where('owner_id', Auth::id());
                    });
                }
                if ($request->ticket_id_search) {
                    $query->where('id', 'like', '%' . $request->ticket_id_search . '%')
                        ->orWhere('title', 'like', '%' . $request->ticket_id_search . '%');
                }
                if ($request->priority_search) {
                    $query->where('priority', '=', $request->priority_search);
                }
                if ($request->category_search) {
                    $query->where('category_id', '=', $request->category_search);
                }
                if ($request->department_search) {
                    $query->where('department_id', '=', $request->department_search);
                }
                if ($request->team_search) {
                    $query->where('team_id', '=', $request->team_search);
                }
                if ($request->status_search) {
                    $query->where('ticket_status_id', '=', $request->status_search);
                }
                if ($request->due_date_search) {
                    $dueDate = '';

                    switch ($request->due_date_search) {
                        case 'today':
                            $todayDate = Carbon::today()->toDateString();
                            $query->whereDate('due_date', '=', $todayDate);
                            break;

                        case 'tomorrow':
                            $tomorrowDate = Carbon::tomorrow()->toDateString();
                            $query->whereDate('due_date', '=', $tomorrowDate);
                            break;

                        case 'this_week':
                            $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
                            $endOfWeek   = Carbon::now()->endOfWeek()->toDateString();
                            $query->whereBetween('due_date', [$startOfWeek, $endOfWeek]);
                            break;

                        case 'this_month':
                            $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
                            $endOfMonth   = Carbon::now()->endOfMonth()->toDateString();
                            $query->whereBetween('due_date', [$startOfMonth, $endOfMonth]);
                            break;

                        default:
                            break;
                    }
                }
            });
        }

        return DataTables::of($tickets)
            ->addColumn('select', function ($tickets) {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400 request_row_checkbox" name="request_ids[]" value="' . $tickets->id . '" />
                </div>';
            })
            ->editColumn('id', function ($tickets) {
                return '<div class="w-[70px]"><span class="text-paragraph">' . ID(prefix: 'REQ', id: $tickets->id) . '</span></div>';
            })
            ->editColumn('title', function ($tickets) {
                return '<a href="' . route('admin.ticket.show', ['ticket' => $tickets?->id]) . '" class=" text-paragraph hover:text-primary-400 block" style="width: 280px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . Str::limit(ucfirst($tickets->title), 50, '...') . '</a>';
            })
            ->editColumn('priority', function ($tickets) {
                $priorityColor = match ($tickets->priority) {
                    'high' => '#EF4444',
                    'low'    => '#10B981',
                    'medium' => '#3B82F6',
                };
                return '<div style="width:100px">
                <span style="color: ' . $priorityColor . '; padding: 5px; border-radius: 4px;" class="text-paragraph pr-3 block">' . Str::ucfirst($tickets->priority) . '</span>
                </div>';
            })
            ->editColumn('department_id', function ($tickets) {
                return '<div style="width:150px"><span class="text-paragraph block">' . Str::ucfirst(@$tickets->department->name) . '</span></div>';
            })
            ->editColumn('category_id', function ($tickets) {
                return '<div style="width:150px"><span class="text-paragraph block">' . Str::ucfirst(@$tickets->category->name) . '</span></div>';
            })
            ->editColumn('sub_category_id', function ($tickets) {
                return '<div style="width:170px"><span class="text-paragraph block">' . Str::ucfirst(@$tickets->sub_category->name) . '</span></div>';
            })
            ->editColumn('ticket_status_id', function ($tickets) {
                $data = "";
                if ($tickets->ticket_status->slug === 'resolved') {
                    $data .= '<div style="width: 120px;"><span class="py-1 letter-transparent border border-resolved-400 text-resolved-400 rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'closed') {
                    $data .= '<div style="width: 120px;"><span class="letter-transparent border border-closed-400 text-closed-400 text-left rounded px-2 py-1">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'open') {
                    $data .= '<div style="width: 120px;"><span class="py-1 letter-transparent border border-open-400 text-open-400 rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'in-progress') {
                    $data .= '<div style="width: 120px;"><span class="py-1 letter-transparent border border-inProgress-400 text-inProgress-400 rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'on-hold') {
                    $data .= '<div style="width: 120px;"><span class="py-1 letter-transparent border border-hold-400 text-hold-400 rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } else {
                    $data .= '<div style="width: 120px;"><span class="py-1 !letter-gray-400 text-paragraph rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                }
                return $data;
            })
            ->editColumn('user_id', function ($tickets) {
                $userName = $tickets->user->name ?? 'Unknown';
                $imageUrl = $tickets->user->image?->url;
                $data     = "
                    <div style='width:160px' class='text-paragraph flex items-center'>
                        " . (
                    $imageUrl
                    ? "<img src='{$imageUrl}' width='30' height='30' style='border-radius: 50%; border: 1px solid #eee;' alt='profile'>"
                    : avatar($userName)
                ) . "
                        <span class='ml-2'>{$userName}</span>
                    </div>";
                return $data;
            })

            ->editColumn('team_id', function ($tickets) {
                $data = '<div style="width:180px"><span class="text-paragraph">' . @$tickets->team->name . '</span></div>';
                return $data;
            })
            ->addColumn('agent', function ($tickets) {
                $data = '<div style="width:180px"><span class="text-paragraph" style="width:138px">' . @$tickets->owners->last()->name . '</span></div>';
                return $data;
            })
            ->editColumn('created_at', function ($tickets) {
                $data = '<div style="width:150px"><span class="text-paragraph" style="width:120px">' . ISODate($tickets?->created_at) . '</span></div>';
                return $data;
            })
            ->addColumn('request_age', function ($tickets) {
                $data = '<div style="width:250px"><span class="text-paragraph">' . dayMonthYearHourMinuteSecond($tickets?->created_at, $tickets?->resolved_at) . '</span></div>';
                return $data;
            })
            ->editColumn('due_date', function ($tickets) {
                $data = '<span class="text-paragraph" style="width:120px">' . ISOdate($tickets->due_date) . '</span>';
                return $data;
            })

            ->addColumn('action_column', function ($tickets) {
                $editUrl   = route('admin.ticket.edit', $tickets?->id);
                $viewUrl   = route('admin.ticket.show', $tickets?->id);
                $deleteUrl = route('admin.ticket.delete', $tickets?->id);
                $viewBtn   = null;
                $editBtn   = null;
                $deleteBtn = null;

                if (Auth::user()->hasRole(['super-admin']) || Auth::user()->can("request view list")) {
                    $viewBtn .= '<li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                    <a href="' . $viewUrl . '">View</a>
                                </li>';
                }
                if (Auth::user()->hasRole(['super-admin']) || Auth::user()->can("request update") && ($tickets->ticket_status->slug != 'closed' && $tickets->ticket_status->slug != 'resolved')) {
                    $editBtn .= '<li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                    <a href="' . $editUrl . '">Edit</a>
                                </li>
                                ';
                }
                if (Auth::user()->hasRole(['super-admin']) || Auth::user()->can("request delete") && ($tickets->ticket_status->slug != 'closed' && $tickets->ticket_status->slug != 'resolved')) {
                    $deleteBtn .= '<li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                        <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="text-">Delete</button>
                        </form>
                    </li>';
                }

                $action = '
                    <div style="padding-left:50px" class="relative">
                        <button type="button" onclick="toggleAction(' . $tickets->id . ')" class="p-3 hover:letter-slate-100 rounded-full">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.9922 12H12.0012" stroke="#5e666e" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.9844 18H11.9934" stroke="#5e666e" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 6H12.009" stroke="#5e666e" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div id="action-' . $tickets->id . '" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
                            <ul>
                                ' . $viewBtn . $editBtn . $deleteBtn . '
                            </ul>
                        </div>
                    </div>';
                return $action;
            })
            ->rawColumns(['action_column'])
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public static function trashTicketListDataTable($request)
    {

        $tickets = Ticket::query()
            ->onlyTrashed()
            ->with(['owners', 'source', 'user', 'team', 'category', 'sub_category', 'ticket_status', 'department']);

        if (Auth::user()->hasRole(['requester', 'Requester'])) {
            $tickets->where('user_id', Auth::id());
        }

        if ($request->all()) {
            $tickets->where(function ($query) use ($request) {

                if ($request->ticket_id_search) {
                    $query->where('id', 'like', '%' . $request->ticket_id_search . '%')
                        ->orWhere('title', 'like', '%' . $request->ticket_id_search . '%');
                }
                if ($request->priority_search) {
                    $query->where('priority', '=', $request->priority_search);
                }
                if ($request->category_search) {
                    $query->where('category_id', '=', $request->category_search);
                }
                if ($request->department_search) {
                    $query->where('department_id', '=', $request->department_search);
                }
                if ($request->team_search) {
                    $query->where('team_id', '=', $request->team_search);
                }
                if ($request->status_search) {
                    $query->where('ticket_status_id', '=', $request->status_search);
                }
            });
        }

        return DataTables::of($tickets)
            ->addColumn('select', function ($tickets) {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400 request_row_checkbox" name="request_ids[]" value="' . $tickets->id . '" />
                </div>';
            })
            ->editColumn('id', function ($tickets) {
                return '<div class="w-[50px]"><span class="text-paragraph">' . '#' . $tickets->id . '</span></div>';
            })
            ->editColumn('title', function ($tickets) {
                return '<p class="text-paragraph block" style="width: 280px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . Str::limit(ucfirst($tickets->title), 50, '...') . '</p>';
            })
            ->editColumn('priority', function ($tickets) {
                $priorityColor = match ($tickets->priority) {
                    'high' => '#EF4444',
                    'low'    => '#10B981',
                    'medium' => '#3B82F6',
                };
                return '<div style="width:100px">
                <span style="color: ' . $priorityColor . '; padding: 5px; border-radius: 4px;" class="text-paragraph pr-3 block">' . Str::ucfirst($tickets->priority) . '</span>
                </div>';
            })
            ->editColumn('department_id', function ($tickets) {
                return '<div style="width:150px"><span class="text-paragraph block">' . Str::ucfirst(@$tickets->department->name) . '</span></div>';
            })
            ->editColumn('category_id', function ($tickets) {
                return '<div style="width:150px"><span class="text-paragraph block">' . Str::ucfirst(@$tickets->category->name) . '</span></div>';
            })
            ->editColumn('sub_category_id', function ($tickets) {
                return '<div style="width:170px"><span class="text-paragraph block">' . Str::ucfirst(@$tickets->sub_category->name) . '</span></div>';
            })
            ->editColumn('ticket_status_id', function ($tickets) {
                $data = "";
                if ($tickets->ticket_status->slug === 'resolved') {
                    $data .= '<div style="width: 120px;"><span class="py-1 letter-transparent border border-resolved-400 text-resolved-400 rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'closed') {
                    $data .= '<div style="width: 120px;"><span class="letter-transparent border border-closed-400 text-closed-400 text-left rounded px-2 py-1">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'open') {
                    $data .= '<div style="width: 120px;"><span class="py-1 letter-transparent border border-open-400 text-open-400 rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'in-progress') {
                    $data .= '<div style="width: 120px;"><span class="py-1 letter-transparent border border-inProgress-400 text-inProgress-400 rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'on-hold') {
                    $data .= '<div style="width: 120px;"><span class="py-1 letter-transparent border border-hold-400 text-hold-400 rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } else {
                    $data .= '<div style="width: 120px;"><span class="py-1 !letter-gray-400 text-paragraph rounded px-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                }
                return $data;
            })
            ->editColumn('user_id', function ($tickets) {
                $userName = $tickets->user->name ?? 'Unknown';
                $imageUrl = $tickets->user->image?->url;
                $data     = "
                    <div style='width:160px' class='text-paragraph flex items-center'>
                        " . (
                    $imageUrl
                    ? "<img src='{$imageUrl}' width='30' height='30' style='border-radius: 50%; border: 1px solid #eee;' alt='profile'>"
                    : avatar($userName)
                ) . "
                        <span class='ml-2'>{$userName}</span>
                    </div>";
                return $data;
            })

            ->editColumn('team_id', function ($tickets) {
                $data = '<div style="width:180px"><span class="text-paragraph">' . @$tickets->team->name . '</span></div>';
                return $data;
            })
            ->addColumn('agent', function ($tickets) {
                $data = '<div style="width:180px"><span class="text-paragraph" style="width:138px">' . @$tickets->owners->last()->name . '</span></div>';
                return $data;
            })
            ->editColumn('created_at', function ($tickets) {
                $data = '<div style="width:150px"><span class="text-paragraph" style="width:120px">' . ISODate($tickets?->created_at) . '</span></div>';
                return $data;
            })
            ->addColumn('request_age', function ($tickets) {
                $data = '<div style="width:250px"><span class="text-paragraph">' . dayMonthYearHourMinuteSecond($tickets?->created_at, $tickets?->resolved_at) . '</span></div>';
                return $data;
            })
            ->editColumn('due_date', function ($tickets) {
                $data = '<span class="text-paragraph" style="width:120px">' . ISOdate($tickets->due_date) . '</span>';
                return $data;
            })

            ->addColumn('action_column', function ($tickets) {
                $restoreUrl         = route('admin.ticket.restore.trash.request', $tickets?->id);
                $permanentDeleteUrl = route('admin.ticket.delete.trash.request', $tickets?->id);
                $restoreBtn         = null;
                $permanentDeleteBtn = null;

                if (Auth::user()->hasRole(['super-admin']) || Auth::user()->can("request restore")) {
                    $restoreBtn .= '<li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                    <a href="' . $restoreUrl . '">Restore</a>
                                </li>
                                ';
                }
                if (Auth::user()->hasRole(['super-admin']) || Auth::user()->can("request force delete")) {
                    $permanentDeleteBtn .= '<li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                        <form action="' . $permanentDeleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="text-">Permanent Delete</button>
                        </form>
                    </li>';
                }

                $action = '
                    <div style="padding-left:50px" class="relative">
                        <button type="button" onclick="toggleAction(' . $tickets->id . ')" class="p-3 hover:letter-slate-100 rounded-full">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.9922 12H12.0012" stroke="#5e666e" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.9844 18H11.9934" stroke="#5e666e" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 6H12.009" stroke="#5e666e" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div id="action-' . $tickets->id . '" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
                            <ul>
                                ' . $restoreBtn . $permanentDeleteBtn . '
                            </ul>
                        </div>
                    </div>';
                return $action;
            })
            ->rawColumns(['action_column'])
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
}
