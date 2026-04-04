<div class="app-header header sticky">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="app-sidebar__toggle" data-toggle="sidebar" href="#" aria-label="Hide Sidebar"></a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                    <a class="nav-link pr-0 leading-none" data-toggle="dropdown" href="#">
                        <span class="avatar avatar-md brround">
                            <i class="fe fe-shield" style="font-size:1.5rem;line-height:2rem;color:#F47920;"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <div class="text-center user pb-0 font-weight-bold">
                            {{ Auth::user()->name ?? 'Super Admin' }}
                        </div>
                        <div class="text-center user-semi-title text-muted mb-2">Super Administrator</div>
                        <div class="dropdown-divider"></div>
                        @if(session('impersonating_org'))
                        <a class="dropdown-item text-warning" href="{{ route('super.impersonate.stop') }}">
                            <i class="dropdown-icon fe fe-user-x"></i> Stop Impersonating
                        </a>
                        <div class="dropdown-divider"></div>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="dropdown-icon fe fe-log-out"></i> Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
