<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ffff">

    <title>@yield('title', config('app.name', 'LCI Production')) </title>
    <link rel="shortcut icon" href="{{ asset('assets/svg/logo.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTableTailwind.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- icon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">




    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins antialiased ">
    <div class="min-h-[80vh] bg-body">
        @include('layouts.navigation')


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @include('layouts.footer')

    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/webcam.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/all.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/solid.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/brands.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/fontawesome.js') }}"></script>
    <script src="{{ asset('assets/js/dataTable.js') }}"></script>
    <script src="{{ asset('assets/js/dataTableTailwind.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        new DataTable('#myTable');
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <x-custom />
    @if (isset($script))
        {{ $script }}
    @endif
</body>

</html>
