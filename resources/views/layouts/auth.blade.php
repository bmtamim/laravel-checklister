<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('backend/css/coreui.min.css') }}" rel="stylesheet">
</head>

<body class="c-app flex-row align-items-center">
    <div class="container">
        @section('content')
        @show
    </div>

    <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <!--[if IE]><!-->
    <script src="vendors/@coreui/icons/js/svgxuse.min.js"></script>
    <!--<![endif]-->
</body>

</html>