<x-app-layout>
    @section('title', 'Create Team')
    @include('team.breadcrumb.create')
    <livewire:team.create-team :categories="$categories" :agentUser="$agentUser" :departments="$departments" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initSelect2form('category_id');
            initSelect2form('agent_id');
            initSelect2form('department_id');
        });
    </script>
</x-app-layout>