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
                'route' => route('admin.department.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Department',
                'route' => route('admin.department.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Update Department',
                'route' => '#',
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>