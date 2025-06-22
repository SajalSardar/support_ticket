<form wire:submit="save">
    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1">
        <div class="flex justify-end items-center mb-[24px]">
            <a href="{{ route('admin.user.index') }}" class="flex items-center px-0 bg-transparent gap-1 text-heading-light text-paragraph hover:text-primary-400 transition-colors">
                User Lists
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
                <div class="p-2 w-full">
                    <x-forms.label for="form.name" required='yes'>
                        {{ __('Name') }}
                    </x-forms.label>
                    <x-forms.text-input type="text" wire:model.live='form.name' placeholder="Name" />
                    <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="p-2 w-full">
                    <x-forms.label for="form.email" required='yes'>
                        {{ __('Email') }}
                    </x-forms.label>
                    <x-forms.text-input wire:model.live="form.email" type="email" placeholder="Enter email" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>
            </div>

            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="p-2 w-full">
                    <x-forms.label for="form.password" required='yes'>
                        {{ __('password') }}
                    </x-forms.label>
                    <x-forms.text-input wire:model.live="form.password" type="password" placeholder="Enter password" />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>
            </div>

            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="p-2 w-full">
                    <x-forms.label for="role_id" required="yes">
                        {{ __('Role') }}
                    </x-forms.label>

                    <x-forms.select-input wire:model.live="form.role_id">
                        <option selected disabled>User Role</option>
                        @forelse ($roles as $role)
                        <option value="{{ $role?->id }}">{{ ucfirst($role?->name) }}</option>
                        @empty
                        <option disabled>No Roles Found</option>
                        @endforelse
                    </x-forms.select-input>

                    <x-input-error :messages="$errors->get('form.role_id')" class="mt-2" />
                </div>
            </div>

            <div class="p-2 mt-[7px]">
                <x-buttons.primary>
                    Create
                </x-buttons.primary>
            </div>
        </div>
    </div>
</form>