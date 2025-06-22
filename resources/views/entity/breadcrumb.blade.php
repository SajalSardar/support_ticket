@props(['value' => $value])
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
                'title' => $value,
                'route' => '#',
            ]
        ];
    @endphp
    <x-breadcrumb :data="$response" />
</div>