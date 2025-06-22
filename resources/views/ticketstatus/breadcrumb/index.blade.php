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
                'route' => route('admin.ticketstatus.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Request Status',
                'route' => route('admin.ticketstatus.index'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>