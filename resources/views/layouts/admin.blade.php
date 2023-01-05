<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Logo --}}
    <link rel="icon" href="{{ asset('assets/images/sample_logo.jpg') }}">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Event Manager') }}</title>

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Styles --}}
    @vite(['resources/sass/portal.scss'])
</head>
<body class="app">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
	        <div class="container-fluid py-2">
		        <div class="app-header-content">
		            <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                        </div>

                        <div class="app-utilities col-auto">
                            <div class="app-utility-item app-user-dropdown dropdown">
                                <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                    <img src="{{ asset('assets/images/avatar.png') }}" alt="user profile">
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li>
                                        <a class="dropdown-item" href="javascript:;">Account</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:;">Settings</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
	            </div>
	        </div>
        </div>
        <div id="app-sidepanel" class="app-sidepanel"> 
	        <div id="sidepanel-drop" class="sidepanel-drop"></div>
	        <div class="sidepanel-inner d-flex flex-column">
		        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
		        <div class="app-branding text-center ps-0">
		            <a class="app-logo text-black fw-bold h4" href="{{ route('admin.dashboard') }}">
                        <span class="text-info">Event</span> Manager
                    </a>
		        </div>
		        
                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is( 'admin.dashboard' ) ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-home"></i>
                                <span class="nav-link-text">Overview</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is( 'admin.occasions' ) ? 'active' : '' }}" href="{{ route('admin.occasions') }}">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span class="nav-link-text">Occasions</span>
                            </a>
                        </li>
                    </ul>
                </nav>
	        </div>
	    </div>
    </header>
    
    <div class="app-wrapper">
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
                @if ( isset( $pageTitle ) )
                    <h2 class="app-title">{{ $pageTitle }}</h2>
                @endif
                @yield('content')
		    </div>
	    </div>
	    
    </div>
    {{-- Scripts --}}
    @vite(['resources/js/app.js', 'resources/js/portal.js'])
</body>
</html>
