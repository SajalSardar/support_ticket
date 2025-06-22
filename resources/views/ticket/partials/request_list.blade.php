<table class="w-full mt-3">
    <thead class="w-full bg-[#F3F4F6] mb-5 rounded">
        <tr>
            <th class="text-start p-2">ID</th>
            <th class="text-start p-2">Title</th>
            <th> </th>
        </tr>
    </thead>

    <tbody>
        @forelse ($ticketStatusWise as $each)
            <tr style="border:1px solid #DDDDDD">

                <td class="p-2">
                    <span class="font-inter font-normal text-slate-500 text-sm">
                        #{{ $each?->id }}
                    </span>
                </td>
                <td class="p-2">
                    <span class="font-inter font-normal text-slate-500 text-sm">
                        {{ Str::limit($each?->title, 30, '...') }}
                    </span>
                </td>
                <td class="relative">
                    <button onclick="toggleAction({{ $each?->id }})" class="p-3 hover:bg-slate-100 rounded-full">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.9922 12H12.0012" stroke="#5e666e" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M11.9844 18H11.9934" stroke="#5e666e" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M12 6H12.009" stroke="#5e666e" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <div id="action-{{ $each->id }}" class="shadow-lg z-30 absolute top-5 right-16"
                        style="display: none">
                        <ul>
                            <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                <a href="{{ route('admin.ticket.edit', ['ticket' => $each?->id]) }}">Edit</a>
                            </li>
                            <li class="px-5 py-1 text-center bg-white">
                                <a href="{{ route('admin.ticket.show', ['ticket' => $each?->id]) }}">View</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <p class="pl-2 pt-2">Data not found!</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
