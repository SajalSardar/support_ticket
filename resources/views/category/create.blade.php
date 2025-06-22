<x-app-layout>
    @section('title', 'Create Category')
    @include('category.breadcrumb.create')
    <livewire:category.create-category :parent_categories="$parent_categories" />
</x-app-layout>