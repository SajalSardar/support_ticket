<x-app-layout>
    @section('title', 'Update Department')
    @include('department.breadcrumb.update')
    <livewire:department.update-department :department="$department" />
</x-app-layout>