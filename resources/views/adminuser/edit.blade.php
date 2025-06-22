<x-app-layout>
    @section('title', 'Update User')
    @include('adminuser.breadcrumb.update')
    @livewire('admin-user.update-admin-user', ['user' => $user])
</x-app-layout>