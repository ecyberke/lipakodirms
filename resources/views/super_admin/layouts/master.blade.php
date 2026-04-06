<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lipakodi Super Admin - @yield('title', 'Dashboard')</title>
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
    <style>
        .org-status { padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-active { background: #d4edda; color: #155724; }
        .status-suspended { background: #fff3cd; color: #856404; }
        .status-pending { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-grace { background: #ffe5d0; color: #7d3b0a; }
    </style>
    @yield('styles')
</head>
<body class="app sidebar-mini light-mode default-sidebar">
<div class="page">
    <div class="page-main">

        {{-- Logo Sidebar --}}
        <div class="app-sidebar app-sidebar2">
            <div class="app-sidebar__logo">
                <a class="header-brand" href="{{ route('super.dashboard') }}">
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
                <li class="menutitles">Main</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('super.dashboard') ? 'active' : '' }}" href="{{ route('super.dashboard') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="menutitles">Organizations</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('super.organizations.index') ? 'active' : '' }}" href="{{ route('super.organizations.index') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span class="side-menu__label">All Organizations</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('super.organizations.create') ? 'active' : '' }}" href="{{ route('super.organizations.create') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        <span class="side-menu__label">Add Organization</span>
                    </a>
                </li>
                <li class="menutitles">Billing</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('super.plans.*') ? 'active' : '' }}" href="{{ route('super.plans.index') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span class="side-menu__label">Subscription Plans</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('super.subscriptions.*') ? 'active' : '' }}" href="{{ route('super.subscriptions.index') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        <span class="side-menu__label">All Subscriptions</span>
                    </a>
                </li>
                <li class="menutitles">System</li>
                @if(session('impersonating_org'))
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('super.impersonate.stop') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span class="side-menu__label">Stop Impersonating</span>
                    </a>
                </li>
                @endif
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('sa-logout').submit();">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span class="side-menu__label">Logout</span>
                    </a>
                    <form id="sa-logout" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </aside>

        {{-- Main Content --}}
        <div class="app-content main-content">
            <div class="side-app">

                {{-- Reuse existing header --}}
                @include('super_admin.layouts.header')

                {{-- Alerts --}}
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
                        <h4 class="page-title">@yield('page-title', 'Dashboard')</h4>
                        @if(session('impersonating_org'))
                        <small class="text-muted">
                            <span class="badge badge-danger">Impersonating</span>
                        </small>
                        @endif
                    </div>
                    <div class="page-rightheader ml-auto d-lg-flex d-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Super Admin</a></li>
                            <li class="breadcrumb-item active">@yield('page-title', 'Dashboard')</li>
                        </ol>
                    </div>
                </div>

                {{-- Content --}}
                <div class="container-fluid">
                    @yield('content')
                </div>

                @include('super_admin.layouts.footer')
            </div>
        </div>
    </div>
</div>

@include('layouts.footer-scripts')
@yield('scripts')
</body>
</html>
