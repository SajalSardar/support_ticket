<x-app-layout>
    @section('title', 'Edit Source')
    @include('source.breadcrumb.update')
    <livewire:source.update-source :source="$source" />
</x-app-layout>
