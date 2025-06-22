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
                'title' => 'Admin',
                'route' => route('admin.user.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'User',
                'route' => route('admin.user.index'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>