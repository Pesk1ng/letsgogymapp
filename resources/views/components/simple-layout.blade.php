<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Let's go gym - Fitness &amp; Management</title>

        <meta name="description" content="">
        <meta name="author" content="Let's go gym">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <meta name="googlebot-news" content="noindex">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <link rel="shortcut icon" sizes="32x32" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="shortcut icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">

        <!-- Modules -->
        @yield('css')
        @vite(['resources/sass/main.scss', 'resources/js/dashmix/app.js'])

        <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
        {{-- @vite(['resources/sass/main.scss', 'resources/sass/dashmix/themes/xwork.scss', 'resources/js/dashmix/app.js']) --}}
        @yield('js')
    </head>

    <body>

        <div id="page-container">
            <main id="main-container">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>