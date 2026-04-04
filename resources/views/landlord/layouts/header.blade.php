<div class="app-header header sticky">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="app-sidebar__toggle" data-toggle="sidebar" href="#" aria-label="Hide Sidebar"></a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                    <a class="nav-link pr-0 leading-none" data-toggle="dropdown" href="#">
                        <span class="avatar avatar-md brround">
                            <i class="fe fe-user" style="font-size:1.5rem;line-height:2rem;"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <div class="text-center user pb-0 font-weight-bold">
                            {{ Auth::guard('landlord')->user()->full_name ?? 'Owner' }}
                        </div>
                        <div class="text-center user-semi-title text-muted mb-2">
                            {{ Auth::guard('landlord')->user()->account_number ?? '' }}
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('landlord.logout') }}">
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
