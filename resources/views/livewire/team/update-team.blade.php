<form wire:submit="update">
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
                    <x-forms.label for="name" required='yes'>
                        {{ __('Team Name') }}
                    </x-forms.label>
                    <x-forms.text-input type="text" wire:model.blur='name' placeholder="Team name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="categories_input">
                        {{ __('Ticket Category') }}
                    </x-forms.label>

                    <div wire:ignore>
                        <x-forms.select2-select wire:model.defer='categories_input' id="categories_input" multiple>
                            <option disabled value="">Select Category</option>
                            @foreach ($categories as $each)
                            <option value="{{ $each->id }}" @if (in_array($each->id, $categories_input)) selected @endif>
                                {{ $each->name }}
                            </option>
                            @endforeach
                        </x-forms.select2-select>
                        <x-input-error :messages="$errors->get('categories_input')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="department_id" required='yes'>
                        {{ __('Department') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <x-forms.select2-select wire:model.defer='department_id' id="department_id">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </x-forms.select2-select>

                        <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="agent_id">
                        {{ __('Agent') }}
                    </x-forms.label>
                    <div wire:ignore>
                        <x-forms.select2-select wire:model.defer='agent_id' id="agent_id" multiple>
                            <option disabled value="">Select agent</option>
                            @foreach ($agentUser as $agent)
                            <option value="{{ $agent->id }}" @if (in_array($agent->id, $agent_id)) selected @endif>
                                {{ $agent->name }}
                            </option>
                            @endforeach
                        </x-forms.select2-select>
                        <x-input-error :messages="$errors->get('agent_id')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="status" required='yes'>
                        {{ __('Status') }}
                    </x-forms.label>
                    <x-forms.select-input wire:model.blur='status'>
                        <option selected disabled>Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </x-forms.select-input>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-2">
                <div class="pt-2 w-full">
                    <x-forms.label for="image">
                        {{ __('Team Image') }}
                    </x-forms.label>
                    <x-forms.input-image wire:model.blur="image" accept="jpg,png,jpeg" max='3024' type="file" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
            </div>
            <div class="pt-6">
                <x-buttons.primary>
                    Update
                </x-buttons.primary>
            </div>
        </div>
    </div>
</form>