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
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Settings',
                'route' => route('admin.department.index'),
            ],
            [
                'title' => 'Department',
                'route' => route('admin.department.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Create Department',
                'route' => route('admin.department.create'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>