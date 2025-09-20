<x-app-layout>
    @section('title', 'Edit Team')
    @include('team.breadcrumb.update')
    <livewire:team.update-team :team="$team" :categories="$categories" />
    @section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                initSelect2('categories_input');
                initSelect2('agent_id');
                initSelect2('department_id');
            });
    </script>
    @endsection
</x-app-layout>