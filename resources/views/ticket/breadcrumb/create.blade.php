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
                'title' => 'Create Request',
                'route' => route('admin.ticket.create'),
            ]
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>