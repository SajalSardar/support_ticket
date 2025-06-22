<x-app-layout>
    @section('title', 'Request List')
    @section('breadcrumb')
    <x-breadcrumb>
        Request List
    </x-breadcrumb>
    @endsection
    <div class="relative">
        @forelse ($tickets as $each)
        @if ($each->name)
        <div class="main-row text-black font-inter font-semibold py-3 mt-3 mb-2" style="cursor: pointer;border-bottom:1px solid #dadada" onclick="toggleSubmenu(this)">

            <div class="flex justify-between">
                <div class="status_count flex items-center">
                    <span>{{ ucfirst($each?->name) . ' Request' }}
                        {{ '(' . count($each?->ticket) . ')' }}</span>
                    <span class="pl-2 arrow">
                        <!-- Arrow down -->
                        <svg width="15" height="5" viewBox="0 0 15 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L5 5L10 0H0Z" fill="#5e666e" />
                        </svg>
                    </span>
                </div>
                <div class="status">
                    <a href="{{ route('admin.ticket.status.wise.list', ['ticket_status' => $each?->slug]) }}" class="border border-slate-300 rounded font-inter font-normal px-2 py-1">View
                        All</a>
                </div>
            </div>
        </div>
        @endif

        <div class="overflow-x-auto submenu">
            <table class="w-full">
                <thead class="w-full bg-slate-100 mb-5">
                    <tr>
                        <th class="text-start p-2">ID</th>
                        <th class="text-start p-2">Title</th>
                        <th class="text-start p-2">Priority</th>
                        <th class="text-start p-2">Status</th>
                        <th class="text-start p-2">Requester Name</th>
                        <th class="text-start p-2">Assigned Team</th>
                        <th class="text-start p-2">Assigned Agent</th>
                        <th class="text-start p-2">Created Date</th>
                        <th class="text-start p-2">Due Date</th>
                        <th class="text-start p-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($each?->ticket as $ticket)
                    <tr>
                        <td class="p-2">
                            <span class="font-inter font-normal text-slate-500 text-sm">
                                #{{ $ticket?->id }}
                            </span>
                        </td>
                        <td class="p-2 font-normal text-gray-400">
                            <span class="font-inter font-normal text-slate-500 text-sm">
                                {{ $ticket?->title }}
                            </span>
                        </td>
                        <td class="p-2 font-normal text-gray-400">
                            <span class="text-{{ $ticket?->priority == 'high' ? 'high' : 'medium' }}-400 font-inter font-semibold">
                                {{ $ticket?->priority }}
                            </span>
                        </td>
                        <td class="p-2 font-normal text-gray-400">
                            @if (strtolower(trim($each->name)) === 'in progress')
                            <x-span-status class="!bg-process-400">
                                {{ $each->name }}
                            </x-span-status>
                            @elseif (strtolower(trim($each->name)) === 'open')
                            <x-span-status class="!bg-green-400">
                                {{ $each->name }}
                            </x-span-status>
                            @elseif (strtolower(trim($each->name)) === 'on hold')
                            <x-span-status class="!bg-orange-400">
                                {{ $each->name }}
                            </x-span-status>
                            @else
                            <x-span-status class="!bg-gray-400">
                                {{ $each->name }}
                            </x-span-status>
                            @endif
                        </td>

                        <td class="p-2 font-normal text-gray-400 flex items-center">
                            <img src="https://i.pravatar.cc/300/5" alt="img" width="35" height="35" style="border-radius: 50%">
                            <span class="ml-2">
                                {{ $ticket?->user->name }}
                            </span>
                        </td>

                        <td class="p-2">
                            <span class="font-normal text-gray-400">
                                {{ $ticket?->team?->name }}
                            </span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">
                                {{ @$ticket->owners->last()->name }}
                            </span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">{{ Helper::ISODate($ticket?->created_at) }}</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">{{ Helper::ISOdate($ticket->due_date) }}</span>
                        </td>
                        <td class="relative">
                            <button onclick="toggleAction('{{ $ticket->id }}')" class="p-3 hover:bg-slate-100 rounded-full">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9922 12H12.0012" stroke="#5e666e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.9844 18H11.9934" stroke="#5e666e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 6H12.009" stroke="#5e666e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <div id="action-{{ $ticket->id }}" class="shadow-lg z-30 absolute top-5 right-16" style="display: none">
                                <ul>
                                    <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                        <a href="{{ route('admin.ticket.edit', ['ticket' => $ticket?->id]) }}">Edit</a>
                                    </li>
                                    <li class="px-5 py-1 text-center bg-white">
                                        <a href="{{ route('admin.ticket.show', ['ticket' => $ticket?->id]) }}">View</a>
                                    </li>
                                    <li class="px-5 py-1 text-center bg-red-600 text-white">
                                        <a href="#">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @empty
        <div>
            <p class="text-center">
                <span class="text-red-500 font-inter font-bold text-lg">No data found !!</span>
            </p>
        </div>
        @endforelse

    </div>

    @section('script')
    <script>
        function toggleSubmenu(row) {
            const mainRow = row;
            const submenu = mainRow.nextElementSibling;
            const toggleIcon = mainRow.querySelector('.arrow');

            if (submenu.style.display === 'list-item') {
                submenu.style.display = 'none';
                toggleIcon.innerHTML = `<svg width="5" height="15" viewBox="0 0 5 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0L5 5L0 10V0Z" fill="#5e666e" />
                                            </svg>`;
            } else {
                submenu.style.display = 'list-item';
                toggleIcon.innerHTML = `<svg width="15" height="5" viewBox="0 0 15 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0L5 5L10 0H0Z" fill="#5e666e"/>
                                            </svg>`;
            }
        }
    </script>
    @endsection

    @section('style')
    <style>
        .submenu {
            display: list-item;
        }

        .main-row.active+.submenu {
            display: none;
        }

        .main-row.active .toggle-icon {
            background-color: red;
        }
    </style>
    @endsection
</x-app-layout>