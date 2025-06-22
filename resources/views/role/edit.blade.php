<x-app-layout>
    @section('title', 'Edit Role')
    @include('role.breadcrumb.update')
    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="flex justify-between mb-[24px]">
            <h3 class="text-detail-heading">Update Role</h3>
            <div>
                <a href="{{ route('admin.role.index') }}" class="flex items-center px-0 bg-transparent gap-1 text-heading-light text-paragraph hover:text-primary-400 transition-colors">
                    Role Lists
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 17C15 17 20 13.3176 20 12C20 10.6824 15 7 15 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div>
                <label for="form.name" class="text-sm font-semibold font-inter text-[#333] inline-block mb-2">
                    {{ __('Role Name') }}
                    <span class="text-red-500">*</span>
                </label>
                <x-forms.text-input type="text" name="role" value="{{ old('role', $role->name) }}" required placeholder="role name..." />
            </div>
        </div>

        <div class="grid md:grid-cols-1 sm:grid-cols-1 sm:gap-1 md:gap-4">
            <div class="mt-6">
                @forelse ($modules as $module)
                <div>
                    <h3 class="text-heading-dark mb-2">{{ $module->name }}</h3>
                    <div class="flex gap-3 flex-wrap items-center">
                        @foreach ($module->permissions as $permission)
                        <label class="flex gap-2 items-center border border-base-500 py-1.5 px-5 rounded">
                            <input class="border border-base-500 rounded focus:ring-transparent p-1 text-primary-400" type="checkbox" value="{{ $permission->name }}" name="permission[]" {{ @in_array(@$permission->id, @$rolePermmission) ? 'checked' : '' }} />
                            <span class="text-paragraph">{{ camelCase($permission->name) }}</span>
                        </label>
                        @endforeach
                    </div>
                    <hr class="my-3">
                </div>
                @empty
                <p class="text-gray-500">No modules available.</p>
                @endforelse
            </div>
        </div>

        <div class="pt-2">
            <x-buttons.primary>
                Update
            </x-buttons.primary>
        </div>

    </form>
</x-app-layout>