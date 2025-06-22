<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Http\Controllers\Controller;
use Helper;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Department::class);
        $departments = Department::get();
        return view("department.index", compact('departments'));
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable()
    {
        Gate::authorize('viewAny', Department::class);
        $department = Cache::remember('department_list', 60 * 60, function () {
            return Department::get();
        });

        return DataTables::of($department)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400" />
                </div>';
            })
            ->editColumn('id', function ($department) {
                return '<div class="w-[50px]"><span class="text-paragraph">' . ID(prefix: 'DPT', id: $department->id) . '</span></div>';
            })
            ->editColumn('status', function ($department) {
                return Helper::status($department->status);
            })
            ->editColumn('name', function ($department) {
                $imageUrl = $department->image?->url ?? asset('assets/images/profile.jpg');
                $image = $department->image
                    ? '<img class="rounded-lg shadow-lg" width="40" height="40" style="border-radius: 50%; border:1px solid #eee;" alt="profile" src="' . $imageUrl . '">'
                    : avatar($department->name);
                return '
                    <div class="flex items-center" style="width: 200px;">
                        ' . $image . '
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . htmlspecialchars($department->name, ENT_QUOTES) . '</h5>
                        </div>
                    </div>';
            })
            ->editColumn('parent_id', function ($department) {
                return '
                    <div class="flex items-center" style="width: 200px">
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . $department->parent ?? 'None' . '</h5>
                        </div>
                    </div>';
            })

            ->editColumn('created_at', function ($department) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $department?->created_at) . '</span>';
            })
            ->addColumn('action_column', function ($department) {
                $editUrl = route('admin.department.edit', $department?->id);
                $deleteUrl = route('admin.department.destroy', $department?->id);

                return
                    '<div class="relative pl-10">
                       <button type="button" onclick="toggleAction(' . $department->id . ')" class="p-3 hover:letter-slate-100 rounded-full">
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
                        <div id="action-' . $department->id . '" class="shadow-lg z-30 absolute top-5 -left-6" style="display: none">
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
        Gate::authorize('create', Department::class);
        return view('department.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
        Gate::authorize('view', $department);
        return view('department.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        Gate::authorize('update', $department);
        return view('department.edit', compact('department'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        Gate::authorize('delete', Department::class);
        $department->delete();
        Artisan::call('optimize:clear');
        flash()->success('Department has been deleted');
        return back();
    }
}
