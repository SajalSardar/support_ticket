<?php

namespace App\Http\Controllers\Admin;

use App\Models\TicketStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Helper;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class TicketStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', TicketStatus::class);
        $ticketStatuses = Cache::remember('ticketStatus_list', 60 * 60, function () {
            return TicketStatus::get();
        });
        return view("ticketstatus.index", compact('ticketStatuses'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable()
    {
        Gate::authorize('viewAny', TicketStatus::class);
        $ticketStatus = Cache::remember('ticketStatus_list', 60 * 60, function () {
            return TicketStatus::get();
        });

        return DataTables::of($ticketStatus)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400" />
                </div>';
            })
            ->editColumn('id', function ($ticketStatus) {
                return '<div class="w-[50px]"><span class="text-paragraph">' . ID(prefix: 'RST', id: $ticketStatus->id) . '</span></div>';
            })
            ->editColumn('status', function ($ticketStatus) {
                return Helper::status($ticketStatus->status);
            })

            ->editColumn('name', function ($ticketStatus) {
                return '
                  <h5 class="text-paragraph">' . htmlspecialchars($ticketStatus->name, ENT_QUOTES) . '</h5>';
            })
            ->editColumn('parent_id', function ($ticketStatus) {
                return '
                    <div class="flex items-center" style="width: 200px">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . $ticketStatus->parent ?? 'None' . '</h5>
                        </div>
                    </div>';
            })

            ->editColumn('created_at', function ($ticketStatus) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $ticketStatus?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($ticketStatus) {
                $editUrl = route('admin.ticketstatus.edit', $ticketStatus?->id);
                $deleteUrl = route('admin.ticketstatus.delete', $ticketStatus?->id);
                return '
                    <div class="relative pl-10">
                        <button onclick="toggleAction(' . $ticketStatus->id . ')" class="p-3 hover:letter-slate-100 rounded-full">
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
                        <div id="action-' . $ticketStatus->id . '" class="shadow-lg z-30 absolute top-5 -left-6" style="display: none">
                            <ul>
                                <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                    <a href="' . $editUrl . '">Edit</a>
                                </li>
                                 
                                <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                    <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure?\');">
                                        ' . csrf_field() . '
                                        ' . method_field("DELETE") . '
                                        <button type="submit" class="text-">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                </div>';
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', TicketStatus::class);
        return view('ticketstatus.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketStatus $ticketstatus)
    {
        //
        Gate::authorize('view', $ticketstatus);
        return view('ticketstatus.show', compact('ticketstatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketStatus $ticketstatus)
    {
        Gate::authorize('update', $ticketstatus);
        return view('ticketstatus.edit', compact('ticketstatus'));
    }

    /**
     * Remove the specified resource from storage.
     * @param TicketStatus $ticketStatus
     */
    public function destroy(TicketStatus $ticketstatus)
    {
        Gate::authorize('delete', TicketStatus::class);
        $ticketstatus->delete();
        Artisan::call('optimize:clear');
        flash()->success('Status has been deleted');
        return back();
    }
}
