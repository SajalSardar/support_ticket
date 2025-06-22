<div>
    @php
        $response = [
            [
                'title' => 'Dashboard',
                'route' => route('dashboard'),
            ],
            [
                'title' => '/',
                'route' => route('dashboard'),
            ],
            [
                'title' => 'Home',
                'route' => route('dashboard'),
            ],
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>