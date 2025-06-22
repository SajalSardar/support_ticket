<x-app-layout>
    @section('title', 'Edit Request')
    @section('breadcrumb')
        <x-breadcrumb>
            Edit Request
        </x-breadcrumb>
    @endsection
    <livewire:ticket.update-ticket :ticket="$ticket" />
</x-app-layout>
