<?php

namespace App\Http\Controllers\Admin;

use App\Models\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Helper;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Source::class);
        $sources = Cache::remember('source_list', 60 * 60, function () {
            return Source::get();
        });

        return view("source.index", compact('sources'));
    }

    /**
     * Define public method displayListDatatable to display the datatable resources
     * @param Request $request
     */
    public function displayListDatatable(Request $request)
    {
        Gate::authorize('viewAny', Source::class);

        $source = Cache::remember('source_list', 60 * 60, function () {
            return Source::get();
        });

        return DataTables::of($source)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center ml-6 w-[50px]"><input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400" />
                </div>';
            })
            ->editColumn('id', function ($source) {
                return '<div class="w-[50px]"><span class="text-paragraph">' . ID(prefix: 'SRC', id: $source->id) . '</span></div>';
            })
            ->editColumn('status', function ($source) {
                return Helper::status($source->status);
            })

            ->editColumn('title', function ($source) {
                $imageUrl = $source->image?->url ?? asset('assets/images/profile.jpg');
                return '<h5 class="text-paragraph">' . htmlspecialchars($source->title, ENT_QUOTES) . '</h5>';
            })
            ->editColumn('created_at', function ($source) {
                return '<span class="text-paragraph text-end">' . ISODate(date: $source?->created_at) . '</span>';
            })

            ->addColumn('action_column', function ($source) {
                $editUrl = route('admin.source.edit', $source?->id);
                $deleteUrl = route('admin.source.destroy', $source?->id);
                return '
                    <div class="relative pl-10">
                        <button onclick="toggleAction(' . $source->id . ')" class="p-3 hover:letter-slate-100 rounded-full">
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
                        <div id="action-' . $source->id . '" class="shadow-lg z-30 absolute top-5 -left-6" style="display: none">
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
        Gate::authorize('create', Source::class);
        return view('source.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        //
        Gate::authorize('view', $source);
        return view('source.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        Gate::authorize('update', $source);

        return view('source.edit', compact('source'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        Gate::authorize('delete', Source::class);
        $source->delete();
        Artisan::call('optimize:clear');
        flash()->success('Source has been deleted');
        return back();
    }
}
