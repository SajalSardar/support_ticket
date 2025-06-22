<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\User;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EntityController extends Controller
{
    /**
     * Get all the resource entities
     * @return View
     */
    public function index(): View
    {
        return view('entity.index');
    }

    public function displayListDatatable(?string $entity)
    {
        $collections = match ($entity) {
            'requesters' => $this->requester(),
            'agents' => $this->agent(),
            'teams' => $this->team(),
            'categories' => $this->categories(),
            default => $this->agent()
        };

        return DataTables::of($collections)
            ->addColumn('select', function () {
                return '
                <div class="flex items-center justify-center ml-6 w-[50px]">
                    <input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400" />
                </div>';
            })
            ->editColumn('id', function ($row) {
                return '
                <div class="w-[50px]">
                    <span class="text-paragraph">' . $row->id . '</span>
                </div>';
            })
            ->editColumn('name', function ($row) {
                return '
                <div class="w-[50px]">
                    <span class="text-paragraph">' . $row->name . '</span>
                </div>';
            })
            ->editColumn('total', function ($row) {
                return '
                <div>
                    <span class="text-paragraph">' . $row->total . '</span>
                </div>';
            })

            ->addColumn('action_column', function ($row) use ($entity) {
                return '
                <div style="padding-left:50px" class="relative">
                    <button type="button" onclick="toggleAction(' . $row->uuid . ')" class="p-3 hover:letter-slate-100 rounded-full">
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
                    <div id="action-' . $row->uuid . '" class="shadow-lg z-30 absolute top-5 -left-6" style="display: none">
                        <ul>
                            ' . ($entity === 'requesters' ? '
                            <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                <a href="' . $row->action->view . '">View</a>
                            </li>' : '') . '
                            
                            <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                <a href="' . $row->action->edit . '">Edit</a>
                            </li>
                            
                            <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                <form action="' . $row->action->delete . '" method="POST" onsubmit="return confirm(\'Are you sure?\');">
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
            ->rawColumns(['select', 'id', 'name', 'total', 'action_column'])
            ->make(true);
    }

    /**
     * Get all requester resources
     * @return array|object
     */
    public function requester(): array|object
    {
        $response = User::query()
            ->withCount('requester_tickets')
            ->orderBy('requester_tickets_count', 'desc')
            ->get();
        return $response->map(
            fn($query, $entity) =>
            (object) [
                'id' => ID(prefix: 'REQ', id: $query->id),
                'uuid' => $query->id,
                'name' => $query->name,
                'total' => $query->requester_tickets_count ?? 0,
                'action' => (object)
                [
                    'edit' => route('admin.user.edit', ['user' => $query->id]),
                    'view'  => route('admin.user.create'),
                    'delete' => route('admin.user.delete', ['user' => $query->id])
                ]
            ]
        )->toBase();
    }

    /**
     * Get all agent resources
     * @return array|object
     */
    public function agent(): array|object
    {
        $response = User::query()
            ->withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->get();

        return $response->map(fn($query) =>
        (object) [
            'id' => ID(prefix: 'AGT', id: $query->id),
            'uuid' => $query->id,
            'name' => $query->name,
            'total' => $query->tickets_count ?? 0,
            'action' => (object)
            [
                'edit' => route('admin.ticket.edit', ['ticket' => $query->id]),
                'delete' => route('admin.ticket.delete', ['ticket' => $query->id])
            ]
        ])->toBase();
    }

    /**
     * Get all team resources
     * @return array|object
     */
    public function team(): array|object
    {
        $response = Team::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->get();
        return $response->map(fn($query) =>
        (object) [
            'id' => ID(prefix: 'TEA', id: $query->id),
            'uuid' => $query->id,
            'name' => $query->name,
            'total' => $query->tickets_count ?? 0,
            'action' => (object)
            [
                'edit' => route('admin.team.edit', ['team' => $query->id]),
                'delete' => route('admin.team.destroy', ['team' => $query->id])
            ]
        ])->toBase();
    }

    /**
     * Get all categories resources
     * @return array|object
     */
    public function categories(): array|object
    {
        $response = Category::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->get();
        return $response->map(fn($query) =>
        (object) [
            'id' => ID(prefix: 'CAT', id: $query->id),
            'uuid' => $query->id,
            'name' => $query->name,
            'total' => $query->ticket_count ?? 0,
            'action' => (object)
            [
                'edit' => route('admin.category.edit', ['category' => $query->id]),
                'delete' => route('admin.category.destroy', ['category' => $query->id])
            ]
        ])->toBase();
    }
}
