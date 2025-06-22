<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class ModuleController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('viewAny', Module::class);

        $modules = Module::all();
        // return $modules;
        return view('module.index', compact('modules'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable(Request $request) {
        Gate::authorize('viewAny', Module::class);
        $modules = Module::all();

        return DataTables::of($modules)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5e666e !important;"></div>';
            })
            ->editColumn('id', function ($modules) {
                return '<span class="text-paragraph text-end">' . '#' . $modules->id . '</span>';
            })
            ->editColumn('name', function ($modules) {
                return '
                    <div class="flex items-center" style="width: 200px">
                            <img src="' . asset('assets/images/profile.jpg') . '" width="40" height="40" style="border-radius: 50%;border:1px solid #eee" alt="profile">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . $modules->name . '</h5>
                        </div>
                    </div>';
            })
            ->editColumn('permission', function ($modules) {
                $isChecked = $modules->permission == '1' ? 'checked' : '';
                return '<input type="checkbox" class="border border-base-500 rounded focus:ring-transparent p-1 text-primary-400" name="remember" ' . $isChecked . '>';
            })
            ->editColumn('view', function ($modules) {
                $isChecked = $modules->view == '1' ? 'checked' : '';
                return '<input type="checkbox" class="border border-base-500 rounded focus:ring-transparent p-1 text-primary-400" name="remember" ' . $isChecked . '>';
            })
            ->editColumn('livewire_component', function ($modules) {
                $isChecked = $modules->livewire_component == '1' ? 'checked' : '';
                return '<input type="checkbox" class="border border-base-500 rounded focus:ring-transparent p-1 text-primary-400" name="remember" ' . $isChecked . '>';
            })
            ->editColumn('mcrp', function ($modules) {
                $isChecked = $modules->mcrp == '1' ? 'checked' : '';
                return '<input type="checkbox" class="border border-base-500 rounded focus:ring-transparent p-1 text-primary-400" name="remember" ' . $isChecked . '>';
            })

            ->editColumn('created_at', function ($modules) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $modules?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($modules) {
                $links = '<div class="relative"><button onclick="toggleAction(' . $modules->id . ')"
                            class="p-3 hover:bg-slate-100 rounded-full">
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
                        <div id="action-' . $modules->id . '" class="shadow-lg z-30 absolute top-5 right-10"
                            style="display: none">
                            <ul>
                                <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                    <a
                                        href="' . route('admin.module.edit', ['module' => $modules->id]) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-white">
                                    <a
                                        href="#">View</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-red-600 text-white">
                                    <a href="' . route('admin.module.destroy', ['module' => $modules->id]) . '">Delete</a>
                                </li>
                            </ul>
                        </div></div>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', Module::class);
        $modules = Module::select('id', 'name', 'slug')->get();
        return view('module.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        Gate::authorize('create', Module::class);
        Permission::create(
            [
                'module_id' => $request->module_id,
                'name'      => Str::lower($request->permission),
            ]
        );
        flash()->success('Permission created!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module) {
        Gate::authorize('view', $module);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module) {
        Gate::authorize('update', $module);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module) {
        Gate::authorize('update', $module);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module) {
        Gate::authorize('delete', $module);
    }
}
