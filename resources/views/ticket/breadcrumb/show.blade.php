@props(['value' => 'Dashboard'])
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
                'title' => 'Requests',
                'route' => route('admin.ticket.all.list'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => isset($value) ? camelCase($value) : 'Dashboard',
                'route' => '#',
            ]
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>