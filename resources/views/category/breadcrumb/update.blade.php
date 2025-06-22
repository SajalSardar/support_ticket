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
                'title' => 'Update Category',
                'route' => '#',
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>