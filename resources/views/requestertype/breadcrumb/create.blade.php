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
                'route' => route('admin.requestertype.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Requester Type',
                'route' => route('admin.requestertype.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Create Requester Type',
                'route' => route('admin.requestertype.create'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>