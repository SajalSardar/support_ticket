<x-app-layout>
    @section('title', 'Team List')
    @include('team.breadcrumb.index')
    <div class="flex justify-between items-center !mt-3 mb-6">
        <div class="flex-1 mt-1">
            <div class="flex justify-end gap-3">
                @can('department create')
                <div>
                    <x-actions.href href="{{ route('admin.team.create') }}" class="block">
                        Create Team
                        <svg class="inline-block" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.5 8V16M16.5 12H8.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12.5 22C18.0228 22 22.5 17.5228 22.5 12C22.5 6.47715 18.0228 2 12.5 2C6.97715 2 2.5 6.47715 2.5 12C2.5 17.5228 6.97715 22 12.5 22Z" stroke="white" stroke-width="1.5" />
                        </svg>
                    </x-actions.href>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="relative">
        <table class="display nowrap" id="data-table" style="width: 100%;border:none;">
            <thead style="background:#F3F4F6; border:none">
                <tr>
                    <th class="text-heading-dark pl-4 !text-end w-[50px]">
                        <span class="flex gap-2 !justify-center !items-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 5H4.16667H17.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15.8332 4.99984V16.6665C15.8332 17.1085 15.6576 17.5325 15.345 17.845C15.0325 18.1576 14.6085 18.3332 14.1665 18.3332H5.83317C5.39114 18.3332 4.96722 18.1576 4.65466 17.845C4.3421 17.5325 4.1665 17.1085 4.1665 16.6665V4.99984M6.6665 4.99984V3.33317C6.6665 2.89114 6.8421 2.46722 7.15466 2.15466C7.46722 1.8421 7.89114 1.6665 8.33317 1.6665H11.6665C12.1085 1.6665 12.5325 1.8421 12.845 2.15466C13.1576 2.46722 13.3332 2.89114 13.3332 3.33317V4.99984" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.3335 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.6665 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input id="checkbox1" type="checkbox" class="w-4 h-4 mr-3 rounded border border-base-500 focus:ring-transparent text-primary-400" />
                        </span>
                    </th>
                    <th class="text-heading-dark pl-5 text-start">ID</th>
                    <th class="text-heading-dark text-start">Team</th>
                    <th class="text-heading-dark text-start">Department</th>
                    <th class="text-heading-dark text-start">Categories</th>
                    <th class="text-heading-dark text-start">Status</th>
                    <th class="text-heading-dark text-start">Created</th>
                    <th class="text-heading-dark text-start"></th>
                </tr>
            </thead>

            @forelse ($collections as $each)
            <tbody x-data="{ open: false }">
                <tr class="text-center border border-base-500">
                    <td>
                        <div class="flex gap-2">
                            <div class="pl-3">
                                <span class="cursor-pointer" @click="open = !open">
                                    <template x-if="!open">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 18L15 12L9 6" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </template>
                                    <template x-if="open">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 9L12 15L18 9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </template>
                                </span>
                            </div>
                            <div class="flex items-center justify-center"><input type="checkbox" class="child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400" />
                            </div>
                        </div>
                    </td>
                    <td>
                        <div><span class="text-paragraph"> {{ ID(prefix: 'TEA', id: $each->id) }} </span></div>
                    </td>
                    <td>
                        <div class="flex gap-1 items-center">
                            <div class="profile">
                                @if (!empty($each->image) && !empty($each->image->url))
                                <img src="{{ $each->image->url }}" alt="user_picture" height="25" width="25">
                                @else
                                {!! avatar($each->name) !!}
                                @endif
                            </div>
                            <div class="infos ps-5 flex">
                                <h5 class="text-paragraph">{{ $each?->name }}</h5>
                            </div>
                        </div>
                    </td>
                    <td class="text-paragraph">
                        <span class="-ml-2">{{ $each->department->name }}</span>
                    </td>
                    <td class="text-paragraph">
                        <span class="-ml-3">
                            @foreach ($each?->teamCategories as $item)
                            {!! Helper::badge($item->name) !!}
                            @endforeach
                        </span>
                    </td>
                    <td class="text-paragraph">
                        <span class="-ml-3">
                            {!! Helper::status($each?->status) !!}
                        </span>
                    </td>
                    <td class="text-paragraph">
                        <p class="-ml-2">
                            {{ Helper::ISOdate($each?->created_at) }}
                        </p>
                    </td>
                    <td>
                        <div class="relative pl-10">
                            <button onclick="toggleAction('{{$each->id}}')" class="p-3 hover:bg-slate-100 rounded-full">
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
                            <div id="action-{{ $each->id }}" class="shadow-lg z-30 absolute top-5 -left-6" style="display: none">
                                <ul>
                                    <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                        <a href="{{ route('admin.team.edit',['team' => $each->id]) }}">Edit</a>
                                    </li>
                                    <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                        <form action="{{ route('admin.team.destroy',['team' => $each->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-paragraph">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr x-show="open" style="display: none;">
                    <td colspan="8">
                        <table class="w-full child-table" style="table-layout: auto;">
                            <thead class="w-full">
                                <tr style="border-bottom:1px solid #ddd">
                                    <th class="text-heading-dark pl-3 !text-end w-[50px]">
                                        <span class="flex gap-2 !justify-center !items-center">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.5 5H4.16667H17.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M15.8332 4.99984V16.6665C15.8332 17.1085 15.6576 17.5325 15.345 17.845C15.0325 18.1576 14.6085 18.3332 14.1665 18.3332H5.83317C5.39114 18.3332 4.96722 18.1576 4.65466 17.845C4.3421 17.5325 4.1665 17.1085 4.1665 16.6665V4.99984M6.6665 4.99984V3.33317C6.6665 2.89114 6.8421 2.46722 7.15466 2.15466C7.46722 1.8421 7.89114 1.6665 8.33317 1.6665H11.6665C12.1085 1.6665 12.5325 1.8421 12.845 2.15466C13.1576 2.46722 13.3332 2.89114 13.3332 3.33317V4.99984" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8.3335 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M11.6665 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <input id="checkbox1" type="checkbox" class="w-4 h-4 mr-3 rounded border border-base-500 focus:ring-transparent text-primary-400" />
                                        </span>
                                    </th>
                                    <th class="text-heading-dark text-start pl-3">ID</th>
                                    <th class="text-heading-dark text-start">Agent</th>
                                    <th class="text-heading-dark text-start">Email</th>
                                    <th class="text-heading-dark text-start">Role</th>
                                    <th class="text-heading-dark text-start">Phone</th>
                                    <th class="text-heading-dark text-start">Designation</th>
                                    <th class="text-heading-dark text-start"></th>
                                </tr>
                            </thead>
                            <tbody class="w-full">
                                @foreach ($each->agents as $agent)
                                <tr style="border-bottom:1px solid #ddd">
                                    <td>
                                        <div class="pl-[36px]">
                                            <input type="checkbox" class="-pl-3 child-checkbox rounded border border-base-500 w-4 h-4 mr-3 focus:ring-transparent text-primary-400" />
                                        </div>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2 pl-3">
                                            {{ $agent->id }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2 pl-3">
                                            {{ $agent->name }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2">
                                            {{ $agent->email }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2">
                                            {{ $agent->roles->first()->name }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2">
                                            {{ $agent->phone }}
                                        </span>
                                    </td>
                                    <td class="text-paragraph">
                                        <span class="-ml-2">
                                            {{ $agent->designation }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="relative">
                                            <button onclick="toggleAction('{{$agent->id}}')" class="p-3 hover:bg-slate-100 rounded-full">
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
                                            <div id="action-{{ $agent->id }}" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
                                                <ul>
                                                    <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                                        <a href="{{ route('admin.user.edit',['user' => $agent->id]) }}">Edit</a>
                                                    </li>
                                                    <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                                        <form>
                                                            <button type="submit" class="text-paragraph">Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            @empty
            <tbody>
                <tr>
                    <td colspan="6" class="text-center">
                        <h5 class="font-medium text-slate-900">No data found !!!</h5>
                    </td>
                </tr>
            </tbody>
            @endforelse

        </table>
        <div class="mt-3">
            {{ $collections->links() }}
        </div>
    </div>
</x-app-layout>