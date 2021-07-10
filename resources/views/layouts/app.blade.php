<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('backend/css/coreui.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">
    @livewireStyles
    @stack('styles')
</head>

<body class="c-app">
    @include('layouts.partials.sidebar')
    <div class="c-wrapper c-fixed-components">
        @include('layouts.partials.header')
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        @section('content')
                        @show
                    </div>
                </div>
            </main>
            @include('layouts.partials.footer')
        </div>
    </div>


    <!-- All Js will be here -->
    <script src="{{ asset('backend/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
