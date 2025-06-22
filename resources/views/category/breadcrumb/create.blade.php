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
                'route' => route('admin.category.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],
            [
                'title' => 'Category',
                'route' => route('admin.category.index'),
            ],
            [
                'title' => '/',
                'route' => '#',
            ],            [
                'title' => 'Create Category',
                'route' => route('admin.category.create'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>