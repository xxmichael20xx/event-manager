<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Event Manager') }}</title>

        {{-- Logo --}}
        <link rel="icon" href="{{ asset('assets/images/sample_logo.jpg') }}">

        {{-- Fonts --}}
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        {{-- Styles --}}
        @vite(['resources/sass/app.scss', 'resources/sass/custom.scss'])
    </head>
    <body class="{{ isset( $bodyClass ) ? $bodyClass : '' }}">
        {{-- Include the partials navigation menu --}}
        @include('partials.nav')
        @yield('content')

        <footer class="bg-dark p-2 text-center">
            <div class="container">
                <p class="text-white mb-0 py-3">All Right Reserved By @website EventManager Inc.</p>
            </div>
        </footer>

        
        {{-- Scripts --}}
        @vite(['resources/js/app.js'])
    </body>
</html>