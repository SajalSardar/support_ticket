<x-app-layout>
    @section('title', 'Create Role')
    @include('role.breadcrumb.create')
    <form method="POST" action="{{ route('admin.role.store') }}">
        @csrf
        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div>
                <label for="form.name" class="text-sm font-semibold font-inter text-[#333] inline-block mb-2">
                    {{ __('Role Name') }}
                    <span class="text-red-500">*</span>
                </label>
                <x-forms.text-input type="text" name="role" placeholder="role name..." />
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
        </div>

        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="mt-6">
                @forelse ($modules as $module)
                <h3 class="text-heading-dark mb-2">{{ $module->name }}</h3>
                <span class="flex gap-3 flex-wrap items-center">
                    @foreach ($module->permissions as $permission)
                    <label class="flex gap-2 items-center border border-base-500 py-1.5 px-5 rounded">
                        <x-forms.checkbox-input type="checkbox" value="{{ $permission->name }}" name="permission[]" />
                        <span class="text-paragraph">{{ camelCase($permission->name) }}</span>
                    </label>
                    @endforeach
                </span>
                <hr class="my-3">
                @empty
                @endforelse
            </div>
        </div>

        <div class="pt-2">
            <x-buttons.primary>
                Create
            </x-buttons.primary>
        </div>
    </form>
</x-app-layout>