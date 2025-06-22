<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Team;
use App\Models\TeamCategory;
use App\Models\User;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Team::class);
        $collections = Team::query()
            ->with('image', 'agents', 'department', 'teamCategories')
            ->paginate(10);
        return view("team.index", compact('collections'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable(Request $request)
    {
        Gate::authorize('viewAny', Team::class);

        $team = Cache::remember('team_list', 60 * 60, function () {
            return Team::get();
        });

        return DataTables::of($team)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5e666e !important;"></div>';
            })
            ->editColumn('id', function ($team) {
                return '<span class="text-paragraph text-end">' . '#' . $team->id . '</span>';
            })
            ->editColumn('status', function ($team) {
                return Helper::status($team->status);
            })

            ->editColumn('name', function ($team) {
                $imageUrl = $team->image?->url ?? asset('assets/images/profile.jpg');
                $image = $team->image
                    ? '<img class="rounded-lg shadow-lg" width="40" height="40" style="border-radius: 50%; border:1px solid #eee;" alt="profile" src="' . $imageUrl . '">'
                    : avatar($team->name);
                return '
                    <div class="flex items-center" style="width: 200px;">
                        ' . $image . '
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . htmlspecialchars($team->name, ENT_QUOTES) . '</h5>
                        </div>
                    </div>';
            })
            ->editColumn('parent_id', function ($team) {
                return '
                    <div class="flex items-center" style="width: 200px">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . $team->parent ?? 'None' . '</h5>
                        </div>
                    </div>';
            })

            ->editColumn('created_at', function ($team) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $team?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($team) {
                $editUrl = route('admin.team.edit', $team?->id);
                $deleteUrl = route('admin.team.destroy', $team?->id);

                return '
                <div class="relative pl-10">
                    <button type="button" onclick="toggleAction(' . $team->id . ')" class="p-3 hover:letter-slate-100 rounded-full">
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
                    
                    <div id="action-' . $team->id . '" class="action-content shadow-lg z-30 absolute top-5 -left-6 bg-white rounded-lg overflow-hidden min-w-[120px]">
                        <ul>
                            <li class="hover:bg-slate-50">
                                <a href="' . $editUrl . '" class="px-5 py-2 text-gray-700 block w-full text-left">
                                    Edit
                                </a>
                            </li>
                            <li class="hover:bg-slate-50">
                                <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure?\');">
                                    ' . csrf_field() . '
                                    ' . method_field("DELETE") . '
                                    <button type="submit" class="px-5 py-2 text-red-600 w-full text-left">
                                        Delete
                                    </button>
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
        Gate::authorize('create', Team::class);
        $usesCategory = TeamCategory::pluck('category_id');
        $departments  = Department::where('status', 1)->get();
        $categories   = Category::query()->whereNotIn('id', $usesCategory)->get();
        $agentUser    = User::role('agent')->get();
        return view('team.create', compact('categories', 'agentUser', 'departments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        Gate::authorize('view', $team);
        return view('team.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Team $team
     */
    public function edit(Team $team)
    {
        Gate::authorize('update', $team);
        $departments  = Department::where('status', 1)->get();
        $usesCategory = TeamCategory::where('team_id', '!=', $team->id)->pluck('category_id');
        $categories   = Category::query()->whereNotIn('id', $usesCategory)->get();
        $agentUser    = User::role('agent')->get();

        return view('team.edit', compact('team', 'categories', 'agentUser', 'departments'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Team $team
     */
    public function destroy(Team $team)
    {
        Gate::authorize('delete', Team::class);
        $team->delete();
        Artisan::call('optimize:clear');
        flash()->success('Team has been deleted');
        return back();
    }
}
