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
    <style>
        .portal-badge { background: #1A4FA8; color: #fff; padding: 3px 12px; border-radius: 20px; font-size: 0.75rem; }
    </style>
</head>
<body class="app sidebar-mini light-mode default-sidebar">
<div class="page">
    <div class="page-main">
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar app-sidebar3">
            <div class="app-sidebar__logo">
                <a href="{{ route('tenant.dashboard') }}" class="header-brand">
                    @if($org && $org->logo)
                        <img src="{{ asset('storage/'.$org->logo) }}" style="width:100px;height:60px;" class="header-brand-img desktop-lgo" alt="{{ $org->name }}">
                    @else
                        <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" style="width:100px;height:60px;" class="header-brand-img desktop-lgo" alt="Lipakodi">
                    @endif
                </a>
            </div>
            <div class="app-sidebar3" style="overflow-y:auto;">
                <ul class="side-menu">
                    <li class="menutitles">Tenant Portal</li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}" href="{{ route('tenant.dashboard') }}">
                            <i class="side-menu__icon fe fe-home"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('tenant.invoices') ? 'active' : '' }}" href="{{ route('tenant.invoices') }}">
                            <i class="side-menu__icon fe fe-file-text"></i>
                            <span class="side-menu__label">My Invoices</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('tenant.service-requests') ? 'active' : '' }}" href="{{ route('tenant.service-requests') }}">
                            <i class="side-menu__icon fe fe-tool"></i>
                            <span class="side-menu__label">Service Requests</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('tenant.notice') ? 'active' : '' }}" href="{{ route('tenant.notice') }}">
                            <i class="side-menu__icon fe fe-log-out"></i>
                            <span class="side-menu__label">Submit Notice</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('tenant.password') ? 'active' : '' }}" href="{{ route('tenant.password') }}">
                            <i class="side-menu__icon fe fe-key"></i>
                            <span class="side-menu__label">Change Password</span>
                        </a>
                    </li>
                    <li class="slide">
                        <form method="POST" action="{{ route('tenant.logout') }}">
                            @csrf
                            <button type="submit" class="side-menu__item border-0 bg-transparent w-100 text-left">
                                <i class="side-menu__icon fe fe-power"></i>
                                <span class="side-menu__label">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="app-content main-content">
            <div class="side-app">
                <div class="app-header header sticky">
                    <div class="container-fluid">
                        <div class="d-flex">
                            <a class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
                            <div class="d-flex order-lg-2 ml-auto align-items-center">
                                <span class="portal-badge mr-3">Tenant Portal</span>
                                <span class="mr-3 font-weight-bold">{{ Auth::guard('tenant')->user()->full_name ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($show_renewal_notice) && $show_renewal_notice)
                <div class="container-fluid mt-3">
                    <div class="alert alert-warning alert-dismissible fade show">
                        <i class="fe fe-alert-triangle"></i>
                        <strong>Notice:</strong> Subscription expires in {{ $subscription_days_left }} days. Contact management.
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                </div>
                @endif

                @if(session('success'))
                <div class="container-fluid mt-2">
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                </div>
                @endif
                @if(session('error'))
                <div class="container-fluid mt-2">
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                </div>
                @endif
                @if($errors->any())
                <div class="container-fluid mt-2">
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                </div>
                @endif

                <div class="page-header">
                    <div class="page-leftheader">
                        <h4 class="page-title">@yield('title', 'Dashboard')</h4>
                    </div>
                </div>

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>
<script src="{{URL::asset('assets/js/sidemenu.js')}}"></script>
<script src="{{URL::asset('assets/js/custom.js')}}"></script>
@yield('scripts')
</body>
</html>
