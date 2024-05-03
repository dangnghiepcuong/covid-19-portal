<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/size.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/notification.js') }}" defer></script>
    <script src="{{ asset('js/toastr.min.js') }}" defer></script>
    <script src="{{ asset('js/pusher.js') }}" defer></script>
    <script src="{{ asset('js/pusher.min.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script defer>
        window.PUSHER_APP_KEY = `{{ env('PUSHER_APP_KEY') }}`
        window.PUSHER_APP_CLUSTER = `{{ env('PUSHER_APP_CLUSTER') }}`
        window.USER_PRIVATE_CHANNEL = `account.{{ Auth::user()->id }}`
        window.EVENT_VACCINATION_REGISTERED = `vaccination-registered`
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="mx-4">
            {{ $slot }}
        </main>
    </div>
    <script src="{{ asset('js/translate.js') }}" defer></script>
</body>

</html>
