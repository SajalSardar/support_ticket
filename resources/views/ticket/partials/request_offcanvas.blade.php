<x-offcanvas :position="'end'" :size="'xl'" :eventname="'offcanvas-request'">

    @slot('header')
    <p class="text-detail-heading">Edit Request</p>
    @endslot

    @slot('body')
    <form action="{{ route('admin.ticket.partialUpdate', ['ticket' => $ticket->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="border border-base-500 p-2 rounded">

            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                <div class="p-2 w-full">
                    <x-forms.label for="request_title" required="yes">
                        {{ __('Request Title') }}
                    </x-forms.label>
                    <x-forms.text-input name="request_title" value="{{ $ticket?->title }}" type="text" required />
                    <x-input-error :messages="$errors->get('request_title')" class="mt-2" />
                </div>
            </div>

            <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-1 p-2 w-full ">
                <x-forms.label for="request_description">
                    {{ __('Request Description') }}
                </x-forms.label>
                <textarea cols="30" id="request_description" rows="10" name="request_description" class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded" placeholder="Add description here..">{!! $ticket->description !!}</textarea>
                <x-input-error :messages="$errors->get('request_description')" class="mt-2" />
            </div>
            <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                <div class="p-2 w-full">
                    <x-forms.input-file name="request_attachment" accept=".pdf,.docx,.ppt,.png,.jpg,.heic,.jpeg" />
                    <x-input-error :messages="$errors->get('request_attachment')" class="mt-2" />
                </div>
            </div>

            <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                <div class="p-2">
                    <x-forms.label for="source_id">
                        {{ __('Source') }}
                    </x-forms.label>

                    <x-forms.select-input name="source_id">
                        <option selected value>Source</option>
                        @foreach ($sources as $each)
                            <option @selected(old('source_id', $ticket?->source_id) == $each?->id) value="{{ $each->id }}">
                                {{ $each?->title }}
                            </option>
                        @endforeach
                    </x-forms.select-input>

                    <x-input-error :messages="$errors->get('source_id')" class="mt-2" />
                </div>

            </div>
            <div class="p-2">
                <x-buttons.primary>
                    Update Ticket
                </x-buttons.primary>
            </div>
        </div>
    </form>

    @endslot
</x-offcanvas>