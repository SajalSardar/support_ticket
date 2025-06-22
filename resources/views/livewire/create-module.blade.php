<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Module') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" wire:submit="save">
                    <div>
                        <x-input-label for="module_name" :value="__('Name *')" />
                        <x-text-input id="module_name" class="block mt-1 w-full" type="text" :value="old('name')" required autofocus wire:model.blur="name" />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    </div>
                    <div class="mt-3">
                        <x-input-label for="folder_name" :value="__('Controller Folder')" />
                        <x-text-input id="folder_name" class="block mt-1 w-full" type="text" :value="old('folder_name')" wire:model.blur="folder_name" />
                        <p class="opacity-75">Controller create in folder!</p>
                    </div>
                    <hr class="mt-3">
                    <div class="mt-3">
                        <label for="permission" class="flex cursor-pointer items-start gap-2">
                            <div class="flex items-center">
                                &#8203;
                                <x-forms.checkbox-input wire:model="permission" id="permission" />
                            </div>

                            <div>
                                <strong class="font-medium text-gray-500"> Create Permission </strong>
                            </div>
                        </label>
                    </div>
                    <div class="mt-3">
                        <label for="mcrp" class="flex cursor-pointer items-start gap-2">
                            <div class="flex items-center">
                                &#8203;
                                <x-forms.checkbox-input wire:model="mcrp" id="mcrp" />
                            </div>

                            <div>
                                <strong class="font-medium text-gray-500">
                                    model,controller,migration,policy,resource
                                    route
                                </strong>
                            </div>
                        </label>
                    </div>
                    <div class="mt-3">
                        <label for="c_view" class="flex cursor-pointer items-start gap-2">
                            <div class="flex items-center">
                                &#8203;
                                <x-forms.checkbox-input wire:model="view" id="c_view" />
                            </div>

                            <div>
                                <strong class="font-medium text-gray-500">Create view</strong>
                            </div>
                        </label>
                    </div>
                    <div class="mt-3">
                        <label for="livewire_component" class="flex cursor-pointer items-start gap-2">
                            <div class="flex items-center">
                                &#8203;
                                <x-forms.checkbox-input wire:model="livewire_component" id="livewire_component" />
                            </div>

                            <div>
                                <strong class="font-medium text-gray-500">Create livewire component</strong>
                            </div>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">


                        <x-buttons.primary class="ms-3">
                            {{ __('Submit') }}
                        </x-buttons.primary>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>