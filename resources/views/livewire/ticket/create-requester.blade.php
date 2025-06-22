<form wire:submit="requesterSave">

    <div class="flex flex-row">
        <div class="md:basis-2/3 sm:basis-full">
            <div class="border border-slate-300 p-5 rounded">

                <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2 w-full">
                        <x-forms.label for="form.request_title" required="yes">
                            {{ __('Request Title') }}
                        </x-forms.label>
                        <x-forms.text-input wire:model="form.request_title" type="text" />
                        <x-input-error :messages="$errors->get('form.request_title')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4 p-2 w-full ">
                    <x-forms.label for="form.request_description">
                        {{ __('Request Description') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <textarea wire:ignore cols="30" id="editor" rows="10" wire:model.lazy='form.request_description'
                            class="w-full py-3 text-base font-normal font-inter border border-slate-400 rounded"
                            placeholder="Add description here.."></textarea>
                        <x-input-error :messages="$errors->get('form.request_description')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2 w-full">
                        <x-forms.input-file wire:model="form.request_attachment" accept=".pdf,.docx,.ppt" />
                        <x-input-error :messages="$errors->get('form.request_attachment')" class="mt-2" />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 sm:grid-cols-1 sm:gap-1 md:gap-4">
                    <div class="p-2">
                        <x-forms.label for="form.category_id" required="yes">
                            {{ __('Category') }}
                        </x-forms.label>

                        <x-forms.select-input wire:model="form.category_id" wire:change="selectChildeCategory">
                            <option value="">Select Category</option>
                            @foreach ($categories as $each)
                                <option value="{{ $each?->id }}" :key="{{ $each->id }}">{{ $each?->name }}
                                </option>
                            @endforeach
                        </x-forms.select-input>

                        <x-input-error :messages="$errors->get('form.category_id')" class="mt-2" />

                        @if ($subCategory && $subCategory->count() > 0)
                            <div class="mt-3">
                                <x-forms.label for="sub_category_id" required="yes">
                                    {{ __('Sub Category') }}
                                </x-forms.label>
                                <x-forms.select-input wire:model="form.sub_category_id" id="sub_category_id">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subCategory as $each)
                                        <option value="{{ $each?->id }}" :key="{{ $each->id }}">
                                            {{ $each?->name }}
                                        </option>
                                    @endforeach
                                </x-forms.select-input>

                                <x-input-error :messages="$errors->get('form.sub_category_id')" class="mt-2" />
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-2">
                    <x-buttons.primary>
                        Create Request
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </div>
</form>
@section('style')
    <style>
        .ck-editor__editable_inline {
            min-height: 250px;
            /* Adjust the height to your preference */
        }
    </style>
@endsection
@section('script')
    <script>
        const editor = ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    @this.set('form.request_description', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
