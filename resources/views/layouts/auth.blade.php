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
        @vite(['resources/sass/app.scss', 'resources/sass/auth.scss', 'resources/sass/material.scss'])
    </head>
    <body class="{{ isset( $bodyClass ) ? $bodyClass : '' }}">
        @yield('content')
        
        {{-- Scripts --}}
        @vite(['resources/js/app.js'])
    </body>
</html>