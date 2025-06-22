<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="This website is about manage events.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/datatable/dataTables.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('style')

</head>

<body>
    <!-- Sidenav start -->
    @include('layouts.partials.sidebar')
    <!-- Sidenav end -->

    <main class="w-full bg-white md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">
        <!-- Navbar Start -->
        @include('layouts.partials.navbar')
        <!-- Navbar End -->
        <div class="pt-8 px-10">

            <!-- Breadcrumb Start -->
            @yield('breadcrumb')
            <!-- Breadcrumb End -->

            <div class=" mt-2 mb-12">
                {{ $slot }}
            </div>
            @livewire('loader.spinner')
        </div>

    </main>
    @livewireScripts
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/datatable/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @yield('script')
</body>

</html>