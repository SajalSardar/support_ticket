<div class="mt-4">
    <div class="flex justify-between">
        <span class="text-detail-heading">
            Internal Notes
        </span>
    </div>

    <form class="mt-2" action="{{ route('admin.ticket.interNoteStore', ['ticket' => $ticket?->id]) }}" method="POST">
        @csrf
        <div>
            <textarea cols="30" id="internal_note" rows="10" name='internal_note' class="w-full py-3 text-paragraph border border-base-500 rounded" placeholder="Add Inter note here.."></textarea>
            <x-input-error :messages="$errors->get('internal_note')" class="mt-2" />
        </div>
        <div class="text-right">
            <x-buttons.primary class="mt-4 ml-auto">
                Add Note
            </x-buttons.primary>
        </div>
    </form>

    @if ( $internalNotes->count() > 0)
    <div class="mt-4 p-4 rounded border border-base-500">
        @foreach ($internalNotes as $note)
        <div class="mb-5">
            <div class="flex items-center gap-2">
                {!! avatar(name: $note?->creator?->name , width: 30, height: 30) !!}
                <p class="text-heading-dark">{{ $note->creator->name }}</p>
            </div>
            <div class="-mt-2">
                <div class="flex gap-1 pl-12 mt-2">
                    <p class="text-paragraph inline-block">Added a private note on</p>
                    <span class="text-paragraph">({{ date('l, d M, Y h:i:a', strtotime($note->created_at)) }})</span>
                </div>
                <div class="pl-12 -mt-3 flex gap-4">
                    <div class="descriptionBox">
                        <p class="text-paragraph inline-block">{!! $note?->note ?? '--' !!}</p>
                    </div>
                    <p class="mt-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.26781 18.8447C4.49269 20.515 5.87613 21.8235 7.55966 21.9009C8.97627 21.966 10.4153 22 12 22C13.5847 22 15.0237 21.966 16.4403 21.9009C18.1239 21.8235 19.5073 20.515 19.7322 18.8447C19.879 17.7547 20 16.6376 20 15.5C20 14.3624 19.879 13.2453 19.7322 12.1553C19.5073 10.485 18.1239 9.17649 16.4403 9.09909C15.0237 9.03397 13.5847 9 12 9C10.4153 9 8.97627 9.03397 7.55966 9.09909C5.87613 9.17649 4.49269 10.485 4.26781 12.1553C4.12104 13.2453 4 14.3624 4 15.5C4 16.6376 4.12104 17.7547 4.26781 18.8447Z" stroke="#5e666e" stroke-width="1.5" />
                            <path d="M7.5 9V6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5V9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M11.9961 15.5H12.0051" stroke="#5e666e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>