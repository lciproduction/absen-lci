<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="shortcut icon" href="{{ asset('assets/svg/logo.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins antialiased  bg-gradient-to-r from-fbf6e9 to-e0d7bd" {{-- style="background-image: url({{ asset('assets/home/cover.jpg') }});" --}}>
    {{ $slot }}


    <x-custom />
</body>

</html>
