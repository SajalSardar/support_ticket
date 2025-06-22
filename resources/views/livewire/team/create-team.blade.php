<form wire:submit="save">
    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1">
        <div class="flex justify-end mb-[24px]">
            <a href="{{ route('admin.team.index') }}" class="flex items-center px-0 bg-transparent gap-1 text-heading-light text-paragraph hover:text-primary-400 transition-colors">
                Team Lists
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
                        {{ __('Team Name') }}
                    </x-forms.label>
                    <x-forms.text-input type="text" wire:model.blur='form.name' placeholder="Team name" />
                    <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="form.category_id" required='yes'>
                        {{ __('Request Category') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <x-forms.select2-select wire:model.defer='form.category_id' id="category_id" multiple>
                            <option value="" disabled>Select Category</option>
                            @foreach ($categories as $each)
                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                            @endforeach
                        </x-forms.select2-select>
                        <x-input-error :messages="$errors->get('form.category_id')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="form.department_id" required='yes'>
                        {{ __('Department') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <x-forms.select2-select wire:model.defer='form.department_id' id="department_id">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </x-forms.select2-select>
                        <x-input-error :messages="$errors->get('form.department_id')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="form.agent_id">
                        {{ __('Agent') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <x-forms.select2-select wire:model.defer='form.agent_id' id="agent_id" multiple>
                            <option value="" disabled>Select agent</option>
                            @foreach ($agentUser as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </x-forms.select2-select>
                        <x-input-error :messages="$errors->get('form.agent_id')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="form.status" required='yes'>
                        {{ __('Status') }}
                    </x-forms.label>
                    <x-forms.select-input wire:model.blur='form.status'>
                        <option selected>Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </x-forms.select-input>
                    <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="form.image">
                        {{ __('Team Image') }}
                    </x-forms.label>
                    <x-forms.input-image wire:model.blur="form.image" accept="jpg,png,jpeg" max='3024' type="file" />
                    <x-input-error :messages="$errors->get('form.image')" class="mt-2" />
                </div>
            </div>
            <div class="pt-6">
                <x-buttons.primary>
                    Create
                </x-buttons.primary>
            </div>
        </div>
    </div>
</form>