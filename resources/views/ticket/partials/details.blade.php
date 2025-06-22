<div class="p-5 border border-slate-200 text-base-400 rounded">
    <div class="flex flex-wrap">
        <div class="basis-full sm:basis-full md:basis-1/2" style="border-right:2px solid #ddd">
            <ul>
                <li class="pb-1">
                    <span class="text-heading-dark">Requester ID:
                    </span>
                    <span class="text-paragraph">#{{ $ticket?->user->id }}</span>
                </li>
                <li class="pb-1">
                    <span class="text-heading-dark">Requester: </span>
                    <span class="text-paragraph">{{ $ticket?->user?->name }}</span>
                </li>
                <li class="pb-1">
                    <span class="text-heading-dark">Phone: </span>
                    <span class="text-paragraph">{{ $ticket?->user?->phone }}</span>
                </li>
                <li class="pb-1">
                    <span class="text-heading-dark">Email: </span>
                    <span class="text-paragraph">{{ $ticket?->user?->email }}</span>
                </li>
                <li class="pb-1">
                    <span class="text-heading-dark">Type: </span>
                    <span class="text-paragraph">{{ $ticket?->user->requester_type?->name }}</span>
                </li>
            </ul>
        </div>
        <div class="basis-full sm:basis-full md:basis-1/2  sm:px-0 1 md:pl-10 lg:pl-6">
            <ul>
                <li class="pb-1">
                    <span class="text-heading-dark">Status: </span>
                    <span class="text-heading-dark">
                        @php
                            $statusColor = match (Str::slug(title: $ticket?->ticket_status?->name)) {
                                'resolved' => 'text-resolved-400',
                                'open' => 'text-open-400',
                                'on-hold' => 'text-open-400',
                                'in-progress' => 'text-inProgress-400',
                                'closed' => 'text-closed-400',
                            };
                        @endphp
                        <span class="{{ $statusColor }}">
                            {{ $ticket?->ticket_status?->name }}
                        </span>
                    </span>
                </li>
                <li class=" pb-1">
                    <span class="text-heading-dark">Priority:
                    </span>
                    <span class="text-heading-dark">
                        @php
                            $priorityColor = match ($ticket?->priority) {
                                'high' => '#EF4444',
                                'low' => '#10B981',
                                'medium' => '#3B82F6',
                            };
                        @endphp
                        <span style="color: {{ $priorityColor }} !important;">{{ ucfirst($ticket?->priority ?? '') }}</span>
                    </span>
                </li>
                <li class="pb-1">
                    <span class="text-heading-dark">Due Data:
                    </span>
                    <span class="text-paragraph">{{ Helper::ISODate($ticket?->due_date) }}</span>
                </li>
                <li class="pb-1">
                    <span class="text-heading-dark">Category:
                    </span>
                    <span class="text-paragraph">{{ $ticket?->category?->name }}</span>
                </li>
                <li class="pb-1">
                    <span class="text-heading-dark">Request Age:
                    </span>
                    <span class="text-paragraph">{{ dayMonthYearHourMinuteSecond($ticket?->created_at, $ticket?->resolved_at) }}</span>
                </li>
            </ul>
        </div>
    </div>

</div>

<div class="flex justify-between mt-4">
    <p class="text-detail-heading">Request Description</p>
</div>

<div class="mt-1 p-4 border border-base-500 rounded descriptionBox">
    {!! $ticket?->description !!}
</div>

@if ($ticket->images && $ticket?->images->count() > 0)
    <div class="flex items-center mt-9">
        <div class="flex items-center">
            <p class="text-detail-heading me-3" style="width: 110px;">Attached File:</p>
            <div class="custom_file flex flex-wrap gap-5">
                @if ($ticket->images && $ticket?->images->count() > 0)
                    @foreach ($ticket->images as $image)
                        @php
                            $size = number_format(explode(' ', $image->size)[0] / (1024 * 1024), 2) . ' MB';
                        @endphp

                        <div class="relative">
                            <a href="{{ route('admin.ticket.downloadFile', ['file' => $image?->id]) }}" style="width: 200px;" class="flex justify-between px-1 py-1 border border-base-500 rounded bg-background-gray">
                                <div class="flex items-center">
                                    <span class="pr-1">
                                        @if ($image->mime == 'pdf')
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19 11C19 10.1825 19 9.4306 18.8478 9.06306C18.6955 8.69552 18.4065 8.40649 17.8284 7.82843L13.0919 3.09188C12.593 2.593 12.3436 2.34355 12.0345 2.19575C11.9702 2.165 11.9044 2.13772 11.8372 2.11401C11.5141 2 11.1614 2 10.4558 2C7.21082 2 5.58831 2 4.48933 2.88607C4.26731 3.06508 4.06508 3.26731 3.88607 3.48933C3 4.58831 3 6.21082 3 9.45584V14C3 17.7712 3 19.6569 4.17157 20.8284C5.34315 22 7.22876 22 11 22H19M12 2.5V3C12 5.82843 12 7.24264 12.8787 8.12132C13.7574 9 15.1716 9 18 9H18.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M21 14H19C18.4477 14 18 14.4477 18 15V16.5M18 16.5V19M18 16.5H20.5M7 19V17M7 17V14H8.5C9.32843 14 10 14.6716 10 15.5C10 16.3284 9.32843 17 8.5 17H7ZM12.5 14H13.7857C14.7325 14 15.5 14.7462 15.5 15.6667V17.3333C15.5 18.2538 14.7325 19 13.7857 19H12.5V14Z" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>

                                        @elseif ($image->mime == 'docx' || $image->mime == 'doc')

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 17H16" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 13H12" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M13 2.5V3C13 5.82843 13 7.24264 13.8787 8.12132C14.7574 9 16.1716 9 19 9H19.5M20 10.6569V14C20 17.7712 20 19.6569 18.8284 20.8284C17.6569 22 15.7712 22 12 22C8.22876 22 6.34315 22 5.17157 20.8284C4 19.6569 4 17.7712 4 14V9.45584C4 6.21082 4 4.58831 4.88607 3.48933C5.06508 3.26731 5.26731 3.06508 5.48933 2.88607C6.58831 2 8.21082 2 11.4558 2C12.1614 2 12.5141 2 12.8372 2.11401C12.9044 2.13772 12.9702 2.165 13.0345 2.19575C13.3436 2.34355 13.593 2.593 14.0919 3.09188L18.8284 7.82843C19.4065 8.40649 19.6955 8.69552 19.8478 9.06306C20 9.4306 20 9.83935 20 10.6569Z" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>

                                        @elseif ($image->mime == 'jpg' || $image->mime == 'jpeg' || $image->mime == 'png')
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.5 9C8.32843 9 9 8.32843 9 7.5C9 6.67157 8.32843 6 7.5 6C6.67157 6 6 6.67157 6 7.5C6 8.32843 6.67157 9 7.5 9Z" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#5e666e" stroke-width="1.5" />
                                                <path d="M5 20.9999C9.37246 15.775 14.2741 8.88398 21.4975 13.5424" stroke="#5e666e" stroke-width="1.5" />
                                            </svg>
                                        @endif
                                    </span>
                                    <div class="info">
                                        <p class="text-paragraph">
                                            {{ Str::limit($image->name, '10', '..') }}
                                        </p>
                                        <p class="text-paragraph">{{ $size }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg width="30" height="30" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 20.5H18" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M12 16.5V4.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M16 12.5C16 12.5 13.054 16.5 12 16.5C10.9459 16.5 8 12.5 8 12.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </a>
                            <form action="{{ route('admin.ticket.trashFile', ['file' => $image->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="absolute -top-4 -right-4 bg-[#eee] hover:bg-[#d6d6d6] z-40 p-2 rounded-full">
                                    <span>
                                        <svg width="12" height="12" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.5 2.5L5 5M5 5L2.5 7.5M5 5L7.5 7.5M5 5L2.5 2.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endif