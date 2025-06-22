<div class="mt-8">
    <div class="grid lg:grid-cols-12 lg:gap-6 md:gap-6 sm:gap-6">
        <div class="lg:col-span-6 lg:mt-9 md:mt-9 sm:mt-0">
            @if (ticketOpenProgressHoldPermission($ticket->ticket_status_id))
            <form action="{{ route('admin.conversation.ticket.conversation', ['ticket' => $ticket?->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <textarea cols="30" id="conversation" rows="10" name="conversation" class="w-full py-3 text-paragraph border border-slate-400 rounded" placeholder="Conversation here.."></textarea>
                    <x-input-error :messages="$errors->get('conversation')" class="mt-2" />
                </div>

                <div class="text-right">
                    <x-buttons.primary class="mt-4 ml-auto">
                        Send
                    </x-buttons.primary>
                </div>
            </form>
            @endif

            @if (is_object($conversations) && $conversations->count() > 0)
            <div class="col-span-2 border border-base-500 p-6 rounded mt-6">
                @foreach ($conversations as $key => $chat)
                @php
                $dateString = $key;
                $formattedDate = \Carbon\Carbon::createFromFormat('Y m d', $dateString)->format('d M, Y');
                @endphp
                <div class="mb-4">
                    <p class="mb-3 text-paragraph">{{ $formattedDate }}</p>
                    @foreach ($chat as $each)
                    <div class="flex items-center gap-2">
                        @php
                        echo avatar($each?->creator?->name);
                        @endphp
                        <p class="text-heading-dark">{{ @$each->creator?->name }}</p>
                    </div>
                    <div class="-mt-2">
                        <div class="pl-10 flex items-center gap-10 mb-3 pt-3 descriptionBox">
                            {!! $each->conversation !!}
                            <span class="flex gap-x-2">
                                <p class="text-paragraph">{{ date('h:i:a', strtotime($each->created_at)) }}</p>
                                @if (ticketOpenProgressHoldPermission($ticket->ticket_status_id))
                                <button type="button" onclick="toggleReplay('{{ $each->id }}')">
                                    <svg class="me-2" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.80823 9.44118L6.77353 7.46899C8.18956 6.04799 8.74462 5.28357 9.51139 5.55381C10.4675 5.89077 10.1528 8.01692 10.1528 8.73471C11.6393 8.73471 13.1848 8.60259 14.6502 8.87787C19.4874 9.78664 21 13.7153 21 18C19.6309 17.0302 18.2632 15.997 16.6177 15.5476C14.5636 14.9865 12.2696 15.2542 10.1528 15.2542C10.1528 15.972 10.4675 18.0982 9.51139 18.4351C8.64251 18.7413 8.18956 17.9409 6.77353 16.5199L4.80823 14.5477C3.60275 13.338 3 12.7332 3 11.9945C3 11.2558 3.60275 10.6509 4.80823 9.44118Z" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                @endif
                            </span>
                        </div>
                        @if (ticketOpenProgressHoldPermission($ticket->ticket_status_id))
                        <div class="replay-{{ $each->id }} mb-3 reply-box" style="opacity: 0; max-height: 0; overflow: hidden; transition: opacity 0.3s ease, max-height 0.3s ease;">
                            <form action="{{ route('admin.conversation.replay', ['conversation' => $each->id]) }}" method="post">
                                @csrf
                                <textarea class="w-full rounded border border-slate-200" name="conversation" rows="3" cols="30" placeholder="reply..."></textarea>
                                <x-buttons.primary class="mt-2 ml-auto">
                                    Replay
                                </x-buttons.primary>
                            </form>
                        </div>
                        @endif

                        @if (is_object($each->replay) && $each->replay->count() > 0)
                        @foreach ($each->replay as $replay)
                        <div class="pl-14">
                            <div class="flex items-center gap-2">
                                @php
                                echo avatar($replay->creator->name);
                                @endphp
                                <p class="text-heading-dark">{{ @$replay->creator->name }}
                                </p>
                            </div>
                            <div class="pl-10 flex items-center gap-4 mb-3 descriptionBox">
                                <p class="text-paragraph">
                                    {!! $replay->conversation !!}
                                </p>
                                <span class="flex">
                                    <p class="text-paragraph">
                                        {{ date('h:i:a', strtotime($replay?->created_at)) }}
                                    </p>
                                </span>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endif

        </div>

        <div class="lg:col-span-3">
            <div class="flex gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.59 13.41L13.42 20.58C13.2343 20.766 13.0137 20.9135 12.7709 21.0141C12.5281 21.1148 12.2678 21.1666 12.005 21.1666C11.7422 21.1666 11.4819 21.1148 11.2391 21.0141C10.9963 20.9135 10.7757 20.766 10.59 20.58L2 12V2H12L20.59 10.59C20.9625 10.9647 21.1716 11.4716 21.1716 12C21.1716 12.5284 20.9625 13.0353 20.59 13.41V13.41Z" stroke="#3D3D3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 7H7.01" stroke="#3D3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h3 class="text-detail-heading">Request Information</h3>
            </div>

            <div class="border border-base-500 rounded px-12 py-8 mt-3">
                <div class="flex justify-center">
                    <div class='flex justify-center items-center text-2xl' style='width: 100px; height: 100px; border-radius: 50%; background: rgba(135, 1, 222, 0.2); color: #8701DE; border: 1px solid #ddd;'> {{ ucfirst(substr(@$each->creator->name, 0, 1))}}</div>
                    {{-- <img src="{{ asset('assets/images/profile.jpg') }}" width="100" height="100" style="border-radius: 50%;border:1px solid #eee" alt="profile"> --}}
                </div>
                <div class="mt-5">
                    <ul>
                        <li class="mb-3">
                            <span class="text-heading-dark">Request: </span>
                            <span class="text-paragraph">{{ $ticket?->user?->name }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="text-heading-dark">ID:
                            </span>
                            <span class="text-paragraph">#{{ $ticket?->user->id }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="text-heading-dark">Email: </span>
                            <span class="text-paragraph">{{ $ticket?->user?->email }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="text-heading-dark">Title: </span>
                            <span class="text-paragraph">{{ $ticket?->title }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="text-heading-dark">Priority: </span>
                            <span class="text-paragraph">{{ ucfirst($ticket?->priority) }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="text-heading-dark">Requester Type: </span>
                            <span class="text-paragraph">{{ $ticket?->user->requester_type?->name }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="text-heading-dark">Created at: </span>
                            <span class="text-paragraph">{{ Helper::ISOdate($ticket?->created_at) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>