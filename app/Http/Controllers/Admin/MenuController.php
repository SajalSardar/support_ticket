<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Menu::class);
        return view('menu.index');
    }

    /**
     * Display a listing of the data table resource.
     * @param Request $request
     */
    public function displayListDatatable(Request $request)
    {
        Gate::authorize('viewAny', Menu::class);
        $menus = Menu::query();

        if ($request->all()) {
            $menus->where(function ($query) use ($request) {
                if ($request->unser_name_search) {
                    $query->where(column: 'name', operator: 'like', value: '%' . $request->unser_name_search . '%');
                }
            });
        }

        return DataTables::of($menus)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400" />
                </div>';
            })
            ->editColumn('id', function ($menus) {
                return '<div class="w-[100px]"><span class="text-paragraph">' . ID(prefix: 'MNU', id: $menus->id) . '</span></div>';
            })
            ->editColumn('order', function ($menus) {
                return '<div class="w-[100px] ml-1"><span class="text-paragraph text-end">' . $menus->order . '</span></div>';
            })
            ->editColumn('route', function ($menus) {
                return '<div class="w-[180px] ml-1"><span class="text-paragraph text-start">' . $menus->route . '</span></div>';
            })
            ->editColumn('url', function ($menus) {
                return '<span class="text-paragraph text-end">' . $menus->url . '</span>';
            })
            ->editColumn('name', function ($menus) {
                return '<div class="flex gap-2">
                            <div>
                                ' . $menus->icon . '
                            </div>
                            <h5 class="text-paragraph">' . $menus->name . '</h5>
                        </div>';
            })
            ->editColumn('created_at', function ($menus) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $menus?->created_at) . '</span>';
            })
            ->addColumn('role', function ($menus) {
                $rolesHtml = '';
                $roles     = json_decode($menus->roles, true);
                foreach ($roles as $role) {
                    $rolesHtml .= '<span class="inline-flex px-3 py-1 bg-inProgress-400/10 !text-inProgress-400 items-center text-paragraph ml-1 rounded">' . $role . '</span>';
                }
                return $rolesHtml;
            })
            ->addColumn('permission', function ($menus) {
                $permissionsHtml = '';
                $permissions     = $menus->permissions ? json_decode($menus->permissions, true) : [];
                foreach ($permissions as $permission) {
                    $permissionsHtml .= '<span class="inline-flex px-3 py-1 bg-paragraph/10 items-center text-paragraph ml-1 rounded">' . $permission . '</span>';
                }
                return $permissionsHtml;
            })
            ->addColumn('action_column', function ($menus) {
                $editUrl   = route('admin.menu.edit', $menus?->id);
                $deleteUrl = route('admin.menu.destroy', $menus->id);
                $links = '<div class="relative pl-10">
                        <button onclick="toggleAction(' . $menus->id . ')" class="p-3 hover:letter-slate-100 rounded-full">
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
                        <div id="action-' . $menus->id . '" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
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

                return $links;
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
        Gate::authorize('create', Menu::class);
        $roles        = Role::where('name', '!=', 'super-admin')->get();
        $parent_menus = Menu::where('parent_id', null)->get();
        $routes       = collect(Route::getRoutes())->map(function ($route) {
            return $route->getName();
        })->push('#');
        $permission_list = Permission::get();
        return view('menu.create', compact('routes', 'roles', 'parent_menus', 'permission_list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('create', Menu::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
        Gate::authorize('view', $menu);
        return view('menu.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        Gate::authorize('update', $menu);
        $roles        = Role::where('name', '!=', 'super-admin')->get();
        $parent_menus = Menu::where('parent_id', null)->get();
        $routes       = collect(Route::getRoutes())->map(function ($route) {
            return $route->getName();
        })->push('#');
        $permission_list = Permission::get();
        return view('menu.edit', compact('roles', 'parent_menus', 'menu', 'routes', 'permission_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        Gate::authorize('update', $menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        Gate::authorize('delete', $menu);
        $menu->delete();
        flash()->success('Menu has been deleted');
        return back();
    }
}
