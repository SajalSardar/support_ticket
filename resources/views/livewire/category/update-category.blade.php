<form wire:submit="update">
    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1">
        <div class="flex justify-end mb-[24px]">
            
            <a href="{{ route('admin.category.index') }}" class="flex items-center px-0 bg-transparent gap-1 text-heading-light text-paragraph hover:text-primary-400 transition-colors">
                 Category Lists
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15 17C15 17 20 13.3176 20 12C20 10.6824 15 7 15 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1">
        <div class="border border-base-500 p-5 rounded">
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pb-2 w-full">
                    <x-forms.label for="form.name" required='yes'>
                        {{ __('Category Name') }}
                    </x-forms.label>
                    <x-forms.text-input type="text" wire:model.live='form.name' placeholder="User name" />
                    <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>
                <div class="pt-2 w-full">
                    <x-forms.label for="form.parent_id">
                        {{ __('Parent Category') }}
                    </x-forms.label>
                    <x-forms.select-input wire:model.live="form.parent_id">
                        <option selected disabled>--Select Parent Category--</option>
                        @foreach ($parent_categories as $each)
                        <option value="{{ $each->id }}" @selected(old('parent_id', $category?->parent_id) == $each->id)>{{ $each->name }}</option>
                        @endforeach
                    </x-forms.select-input>
                    <x-input-error :messages="$errors->get('form.parent_id')" class="mt-2" />
                </div>
                <div class="pt-2 w-full">
                    <x-forms.label for="form.status" required='yes'>
                        {{ __('Status') }}
                    </x-forms.label>
                    <x-forms.select-input wire:model.live="form.status">
                        <option disabled>--Select Status--</option>
                        <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>Inactive</option>
                    </x-forms.select-input>
                    <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
                <div class="pt-2 w-full">
                    <x-forms.label for="form.image">
                        {{ __('Image') }}
                    </x-forms.label>
                    <x-forms.input-image type="file" wire:model="form.image" accept=".jpg,.jpeg, .png" />
                    <x-input-error :messages="$errors->get('form.image')" class="mt-2" />
                </div>
                <div class="pt-6">
                    <x-buttons.primary>
                        Update
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </div>
</form>