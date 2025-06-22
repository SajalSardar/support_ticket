<x-app-layout>
    @section('title', 'Edit Menu')
    @include('menu.breadcrumb.update')
    <livewire:menu.update-menu :roles="$roles" :parent_menus="$parent_menus" :menu="$menu" :routes="$routes" :permission_list="$permission_list" />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initSelect2('role');
            initSelect2('permission');
        });
    </script>
</x-app-layout>