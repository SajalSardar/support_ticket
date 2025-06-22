<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Category::class);
        $collections = Cache::remember('category_list', 60 * 60, function () {
            return Category::query()->with('image', 'parent')->get();
        });

        return view("category.index", compact('collections'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable(Request $request)
    {
        Gate::authorize('viewAny', Category::class);
        $category = Cache::remember('category_list', 60 * 60, function () {
            return Category::query()->get();
        });
        return DataTables::of($category)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400" />
                </div>';
            })
            ->editColumn('id', function ($category) {
                return '<div class="w-[50px]"><span class="text-paragraph">' . ID(prefix: 'CAT', id: $category->id). '</span></div>';
            })
            ->editColumn('status', function ($category) {
                return Helper::status($category->status);
            })
            ->editColumn('name', function ($category) {
                $imageUrl = $category->image?->url ?? null;
                $imageTag = $imageUrl
                    ? '<img class="rounded-lg shadow-lg" width="40" height="40" style="border-radius: 50%; border:1px solid #eee;" alt="profile" src="' . $imageUrl . '">'
                    : avatar($category->name);

                return '
                    <div class="flex items-center" style="width: 200px;">
                        ' . $imageTag . '
                        <div class="infos ps-5">
                            <h5 class="text-paragraph">' . htmlspecialchars($category->name, ENT_QUOTES) . '</h5>
                        </div>
                    </div>';
            })

            ->editColumn('parent_id', function ($category) {
                return '<h5 class="text-paragraph">' . $category?->parent?->name ?? 'None' . '</h5>';
            })

            ->editColumn('created_at', function ($category) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $category?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($category) {
                $editUrl = route('admin.category.edit', $category?->id);
                $deleteUrl = route('admin.category.destroy', $category?->id);

                return
                    '<div class="relative pl-10">
                        <button onclick="toggleAction(' . $category->id . ')" class="p-3 hover:letter-slate-100 rounded-full">
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
                        <div id="action-' . $category->id . '" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
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
        Gate::authorize('create', Category::class);
        $parent_categories = Category::query()->get();
        return view('category.create', compact('parent_categories'));
    }

    /**
     * Display the specified resource.
     * @param Category $category
     */
    public function show(Category $category)
    {
        Gate::authorize('view', $category);
        return view('category.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Category $category
     */
    public function edit(Category $category)
    {
        Gate::authorize('update', $category);
        $parent_categories = Category::query()->get();
        return view('category.edit', compact('category', 'parent_categories'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', Category::class);
        $category->delete();
        flash()->success('Category has been deleted');
        return back();
    }
}
