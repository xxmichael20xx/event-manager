@php
    $title = 'Event Manager';

    if ( isset( $pageTitle ) ) {
        $title = $pageTitle . ' | ' . $title;
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>

        {{-- Logo --}}
        <link rel="icon" href="{{ asset('assets/images/sample_logo.jpg') }}">

        {{-- Fonts --}}
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        @if ( Route::is( 'events' ) )
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick.css') }}"/>
        @endif

        {{-- Styles --}}
        @vite(['resources/sass/app.scss', 'resources/sass/custom.scss'])
    </head>
    <body class="{{ isset( $bodyClass ) ? $bodyClass : '' }}">
        {{-- Include the partials navigation menu --}}
        @include('partials.nav')
        @yield('content')

        @if ( Route::is( 'my-account' ) )
            <div class="mt-5 pt-5"></div>
        @endif

        <footer class="bg-dark p-2 text-center {{ Route::is( 'my-account' ) ? 'fixed-bottom' : '' }}">
            <div class="container">
                <p class="text-white mb-0 py-3">All Right Reserved By @website EventManager Inc.</p>
            </div>
        </footer>

        
        {{-- Scripts --}}
        @vite(['resources/js/app.js'])
        @if ( Route::is( 'events' ) )
            <script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('assets/slick/slick.min.js') }}"></script>
        @endif
        @yield('scripts')
    </body>
</html>