<x-app-layout>
    @section('title', 'Edit Request Type')
    @include('requestertype.breadcrumb.update')
    <livewire:requester-type.update-requester-type :requestertype="$requestertype" />
</x-app-layout>
