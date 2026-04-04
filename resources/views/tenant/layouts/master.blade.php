<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $org->name ?? 'Tenant Portal' }} - @yield('title', 'Dashboard')</title>
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

        {{-- Logo Sidebar (matches app-sidebar2) --}}
        <div class="app-sidebar app-sidebar2">
            <div class="app-sidebar__logo">
                <a class="header-brand" href="{{ route('tenant.dashboard') }}">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" style="width:100px;height:60px;" class="header-brand-img desktop-lgo" alt="Lipakodi">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" style="width:100px;height:60px;" class="header-brand-img dark-logo" alt="Lipakodi">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" class="header-brand-img mobile-logo" alt="Lipakodi">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" class="header-brand-img darkmobile-logo" alt="Lipakodi">
                </a>
            </div>
        </div>

        {{-- Menu Sidebar (matches app-sidebar3) --}}
        <aside class="app-sidebar app-sidebar3">
            <ul class="side-menu">
                <li class="menutitles">MAIN</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}" href="{{ route('tenant.dashboard') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="menutitles">INVOICING</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        <span class="side-menu__label">Invoices</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('tenant.invoices') }}" class="slide-item"> My Invoices</a></li>
                        <li><a href="{{ route('tenant.payments') }}" class="slide-item"> My Payments</a></li>
                    </ul>
                </li>
                <li class="menutitles">MAINTENANCE</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span class="side-menu__label">Service Request</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('tenant.service-requests') }}" class="slide-item"> Add Request</a></li>
                        <li><a href="{{ route('tenant.service-requests.list') }}" class="slide-item"> My Requests</a></li>
                    </ul>
                </li>
                <li class="menutitles">NOTICE</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('tenant.notice') ? 'active' : '' }}" href="{{ route('tenant.notice') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-4-5z"/></svg>
                        <span class="side-menu__label">Submit Notice</span>
                    </a>
                </li>
                <li class="menutitles">REPORTS</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span class="side-menu__label">Reports</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('tenant.statement') }}" class="slide-item"> My Statement</a></li>
                    </ul>
                </li>
            </ul>
            </ul>
        </aside>

        {{-- Main Content --}}
        <div class="app-content main-content">
            <div class="side-app">

                {{-- Header --}}
                @include('tenant.layouts.header')

                {{-- Alerts --}}
                @if(isset($show_renewal_notice) && $show_renewal_notice)
                <div class="alert alert-warning alert-dismissible fade show mx-4 mt-2">
                    <i class="fe fe-alert-triangle"></i> <strong>Notice:</strong> Subscription expires in {{ $subscription_days_left }} days. Contact management.
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                @endif
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mx-4 mt-2">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mx-4 mt-2">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger mx-4 mt-2">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </div>
                @endif

                {{-- Page Header --}}
                <div class="page-header">
                    <div class="page-leftheader">
                        <h4 class="page-title">@yield('title', 'Dashboard')</h4>
                        <small class="text-muted">{{ Auth::guard('tenant')->user()->full_name ?? '' }} &mdash; {{ Auth::guard('tenant')->user()->account_number ?? '' }}</small>
                    </div>
                    <div class="page-rightheader ml-auto d-lg-flex d-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title', 'Dashboard')</li>
                        </ol>
                    </div>
                </div>

                {{-- Content --}}
                <div class="container-fluid">
                    @yield('content')
                </div>

                {{-- Footer --}}
                @include('tenant.layouts.footer')
            </div>
        </div>
    </div>
</div>

@include('layouts.footer-scripts')
</body>
</html>
