<div>
    @php
        $response = [
            [
                'title' => 'Home',
                'route' => route('dashboard'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Settings',
                'route' => route('admin.team.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Team',
                'route' => route('admin.team.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Create Team',
                'route' => route('admin.team.create'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>