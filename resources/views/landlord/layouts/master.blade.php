<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $org->name ?? 'Owner Portal' }} - @yield('title', 'Dashboard')</title>
    <link rel="icon" href="{{URL::asset('assets/images/brand/favicon.ico')}}" type="image/x-icon"/>
    <link href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/css/dark.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/css/skins.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/css/animated.css')}}" rel="stylesheet" />
    <link id="theme" href="{{URL::asset('assets/css/sidemenu.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/web-fonts/icons.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/web-fonts/plugin.css')}}" rel="stylesheet" />
</head>
<body class="app sidebar-mini light-mode default-sidebar">
<div class="page">
    <div class="page-main">

        {{-- Logo Sidebar --}}
        <div class="app-sidebar app-sidebar2">
            <div class="app-sidebar__logo">
                <a class="header-brand" href="{{ route('landlord.dashboard') }}">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" style="width:100px;height:60px;" class="header-brand-img desktop-lgo" alt="Lipakodi">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" style="width:100px;height:60px;" class="header-brand-img dark-logo" alt="Lipakodi">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" class="header-brand-img mobile-logo" alt="Lipakodi">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" class="header-brand-img darkmobile-logo" alt="Lipakodi">
                </a>
            </div>
        </div>

        {{-- Menu Sidebar --}}
        <aside class="app-sidebar app-sidebar3">
            <ul class="side-menu">
                <li class="menutitles">MAIN</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('landlord.dashboard') ? 'active' : '' }}" href="{{ route('landlord.dashboard') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="menutitles">PROPERTIES</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('landlord.properties') ? 'active' : '' }}" href="{{ route('landlord.properties') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span class="side-menu__label">My Properties</span>
                    </a>
                </li>
                <li class="menutitles">MAINTENANCE</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('landlord.service-requests') ? 'active' : '' }}" href="{{ route('landlord.service-requests') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.07 4.93l-1.41 1.41M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M4.93 4.93l1.41 1.41"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
                        <span class="side-menu__label">Service Requests</span>
                    </a>
                </li>
                <li class="menutitles">REPORTS</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        <span class="side-menu__label">Reports</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('landlord.statements') }}" class="slide-item"> Statement</a></li>
                        <li><a href="{{ route('landlord.remittance') }}" class="slide-item"> Remittance</a></li>
                        <li><a href="{{ route('landlord.maintenance-report') }}" class="slide-item"> Maintenance Report</a></li>
                        <li><a href="{{ route('landlord.property-status') }}" class="slide-item"> Property Status</a></li>
                    </ul>
                </li>
            </ul>
        </aside>

        {{-- Main Content --}}
        <div class="app-content main-content">
            <div class="side-app">
                @include('landlord.layouts.header')

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mx-4 mt-2">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger mx-4 mt-2">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </div>
                @endif

                <div class="page-header">
                    <div class="page-leftheader">
                        <h4 class="page-title">@yield('title', 'Dashboard')</h4>
                        <small class="text-muted">{{ Auth::guard('landlord')->user()->full_name ?? '' }} &mdash; {{ Auth::guard('landlord')->user()->account_number ?? '' }}</small>
                    </div>
                    <div class="page-rightheader ml-auto d-lg-flex d-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('landlord.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title', 'Dashboard')</li>
                        </ol>
                    </div>
                </div>

                <div class="container-fluid">
                    @yield('content')
                </div>

                @include('landlord.layouts.footer')
            </div>
        </div>
    </div>
</div>

@include('layouts.footer-scripts')
</body>
</html>
