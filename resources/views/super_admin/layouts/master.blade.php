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
        .super-badge { background: #F47920; color: #fff; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
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
        <!-- Sidebar -->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar app-sidebar3">
            <div class="app-sidebar__logo">
                <a href="{{ route('super.dashboard') }}" class="header-brand">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" style="width:100px;height:60px;" class="header-brand-img desktop-lgo" alt="Lipakodi">
                    <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" style="width:100px;height:60px;" class="header-brand-img dark-logo" alt="Lipakodi">
                </a>
            </div>
            <div class="app-sidebar3" style="overflow-y:auto;">
                <ul class="side-menu">
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('super.dashboard') ? 'active' : '' }}" href="{{ route('super.dashboard') }}">
                            <i class="side-menu__icon fe fe-home"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                    <li class="menutitles">Organizations</li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('super.organizations.*') ? 'active' : '' }}" href="{{ route('super.organizations.index') }}">
                            <i class="side-menu__icon fe fe-briefcase"></i>
                            <span class="side-menu__label">All Organizations</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('super.organizations.create') }}">
                            <i class="side-menu__icon fe fe-plus-circle"></i>
                            <span class="side-menu__label">Add Organization</span>
                        </a>
                    </li>
                    <li class="menutitles">Billing</li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('super.plans.*') ? 'active' : '' }}" href="{{ route('super.plans.index') }}">
                            <i class="side-menu__icon fe fe-tag"></i>
                            <span class="side-menu__label">Subscription Plans</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('super.subscriptions.*') ? 'active' : '' }}" href="{{ route('super.subscriptions.index') }}">
                            <i class="side-menu__icon fe fe-file-text"></i>
                            <span class="side-menu__label">All Subscriptions</span>
                        </a>
                    </li>
                    <li class="menutitles">System</li>
                    @if(session('impersonating_org'))
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('super.impersonate.stop') }}">
                            <i class="side-menu__icon fe fe-log-out"></i>
                            <span class="side-menu__label">Stop Impersonating</span>
                        </a>
                    </li>
                    @endif
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('sa-logout').submit();">
                            <i class="side-menu__icon fe fe-power"></i>
                            <span class="side-menu__label">Logout</span>
                        </a>
                        <form id="sa-logout" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="app-content main-content">
            <div class="side-app">
                <!-- Header -->
                <div class="app-header header sticky">
                    <div class="container-fluid">
                        <div class="d-flex">
                            <a class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
                            <div class="d-flex order-lg-2 ml-auto">
                                @if(session('impersonating_org'))
                                <span class="badge bg-warning text-dark align-self-center me-3">
                                    <i class="fe fe-user"></i> Impersonating
                                </span>
                                @endif
                                <span class="super-badge align-self-center me-3">
                                    <i class="fe fe-shield"></i> {{ Auth::user()->name ?? 'Super Admin' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Header -->
                <div class="page-header">
                    <div class="page-leftheader">
                        <h4 class="page-title">@yield('page-title', 'Dashboard')</h4>
                    </div>
                </div>

                <!-- Content -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>
<script src="{{URL::asset('assets/js/sidemenu.js')}}"></script>
<script src="{{URL::asset('assets/js/custom.js')}}"></script>
@yield('scripts')
</body>
</html>
