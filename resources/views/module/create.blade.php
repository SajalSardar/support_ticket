<x-app-layout>
    <livewire:create-module />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-4">Create Permission</h2>
                    <form method="POST"  action="{{ route('admin.module.store') }}">
                        @csrf
                        <div>
                            <x-input-label :value="__('Module')" />
                            
                            <x-forms.select-input name="module_id">
                                <option value="">Select Module</option>
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                @endforeach
                            </x-forms.select-input>
                        </div>
                        <div>
                            <x-input-label :value="__('Permission')" />
                            <x-text-input id="module_name" class="block mt-1 w-full" type="text" :value="old('name')" name="permission" />
    
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
</x-app-layout>
