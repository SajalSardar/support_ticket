<x-app-layout>
    @section('title', 'Update Category')
    @include('category.breadcrumb.update')
    <livewire:category.update-category :category="$category" :parent_categories="$parent_categories" />
</x-app-layout>