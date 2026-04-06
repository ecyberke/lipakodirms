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
    .menutitles{
        color: #000000;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 500;
        letter-spacing: .5px;
        margin-bottom: 5px;
        height: 15px;
        padding-left: 20px;
    }
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
                <li class="menutitles">MAIN</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('super.dashboard') ? 'active' : '' }}" href="{{ route('super.dashboard') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li><br>

                <li class="menutitles">ORGANIZATIONS</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span class="side-menu__label">Company/Landlord</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('super.organizations.create') }}" class="slide-item"> Add Organization</a></li>
                        <li><a href="{{ route('super.organizations.index') }}" class="slide-item"> List Organizations</a></li>
                    </ul>
                </li><br>

                <li class="menutitles">BILLING</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span class="side-menu__label">Subscriptions</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('super.plans.index') }}" class="slide-item"> Edit Subscriptions</a></li>
                        <li><a href="{{ route('super.subscriptions.index') }}" class="slide-item"> List Subscriptions</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span class="side-menu__label">Invoicing</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('super.invoices.create') }}" class="slide-item"> Add Invoice</a></li>
                        <li><a href="{{ route('super.invoices.list') }}" class="slide-item"> List Invoices</a></li>
                        <li><a href="{{ route('super.invoices.pay') }}" class="slide-item"> Pay Invoice</a></li>
                        <li><a href="{{ route('super.invoices.payments') }}" class="slide-item"> List Payments</a></li>
                    </ul>
                </li><br>

                <li class="menutitles">USERS</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="side-menu__label">Users</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('super.users.create') }}" class="slide-item"> Add User</a></li>
                        <li><a href="{{ route('super.users.index') }}" class="slide-item"> List Users</a></li>
                    </ul>
                </li><br>

                <li class="menutitles">CONFIGURATION</li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('super.connections') ? 'active' : '' }}" href="{{ route('super.connections') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.07 4.93l-1.41 1.41M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M4.93 4.93l1.41 1.41"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
                        <span class="side-menu__label">Connections</span>
                    </a>
                </li><br>

                @if(session('impersonating_org'))
                <li class="menutitles">SESSION</li>
                <li class="slide">
                    <form method="POST" action="{{ route('super.impersonate.stop') }}" class="mb-0">
                        @csrf
                        <button type="submit" class="side-menu__item w-100 text-left border-0 bg-transparent">
                            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            <span class="side-menu__label text-warning">Switch to Super Admin</span>
                        </button>
                    </form>
                </li>
                @endif
            </ul>
            <form id="sa-logout" action="{{ route('super.logout') }}" method="POST" class="d-none">@csrf</form>
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
