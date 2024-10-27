<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel')) - {{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logoo.png') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins  antialiased bg-body min-h-screen flex justify-center items-center">
    <div class="flex flex-col justify-center items-center w-full relative">
    <img src="{{ asset('assets/images/logoputih.png') }}"
         class="md:max-w-sm max-w-44 rounded-lg object-cover lg:hidden" />

    <x-card.card-default class="w-2/3 bg-gradient-to-tr from-red-950 to-red-700 shadow-inner shadow-yellow-500">
        {{ $slot }}
    </x-card.card-default>
</div>


    <x-custom />
</body>

</html>
