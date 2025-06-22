<x-app-layout>
    @section('title', 'Edit Request Status')
    @include('ticketstatus.breadcrumb.update')
    <livewire:ticket-status.update-ticket-status :ticketstatus="$ticketstatus" />
</x-app-layout>
