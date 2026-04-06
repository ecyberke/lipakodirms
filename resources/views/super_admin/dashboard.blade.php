@extends('super_admin.layouts.master')
@section('title', 'Dashboard')
@section('page-title', 'Super Admin Dashboard')

@section('content')

<!--Row-->
<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-success icon-dropshadow-success" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88z"></path>
                        </svg>
                        <p class="mb-1">Active Organizations</p>
                        <h2 class="mb-1 font-weight-bold">{{ $stats['active_orgs'] }}</h2>
                        <div class="progress progress-sm mt-3 bg-success-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-secondary icon-dropshadow-secondary" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88z"></path>
                        </svg>
                        <p class="mb-1">Total Organizations</p>
                        <h2 class="mb-1 font-weight-bold">{{ $stats['total_orgs'] }}</h2>
                        <div class="progress progress-sm mt-3 bg-secondary-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-primary icon-dropshadow-primary" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <p class="mb-1">Total Active Units</p>
                        <h2 class="mb-1 font-weight-bold">{{ number_format($stats['total_units']) }}</h2>
                        <div class="progress progress-sm mt-3 bg-primary-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 99%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-warning icon-dropshadow-warning" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156z"></path>
                        </svg>
                        <p class="mb-1">Suspended / Pending</p>
                        <h2 class="mb-1 font-weight-bold">{{ $stats['suspended_orgs'] + $stats['pending_orgs'] }}</h2>
                        <div class="progress progress-sm mt-3 bg-orange-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange" style="width: 20%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--Row-->
<div class="row row-deck">
    {{-- Expiring Soon --}}
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Subscriptions Expiring Soon</h3>
            </div>
            <div class="card-body overflow-hidden">
                <div class="h-400 scrollbar3" id="scrollbar3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-nowrap">
                            <thead>
                                <tr>
                                    <th>Organization</th>
                                    <th>Expires</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($expiring_soon as $sub)
                            <tr>
                                <td>{{ $sub->organization->name }}</td>
                                <td><span class="badge badge-warning">{{ $sub->ends_at->format('d M Y') }}</span></td>
                                <td>KES {{ number_format($sub->amount) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">No subscriptions expiring soon</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Organizations --}}
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="card card-block">
            <div class="card-header d-sm-flex d-block">
                <h3 class="card-title">Recent Organizations</h3>
                <div class="ml-auto">
                    <a href="{{ route('super.organizations.create') }}" class="btn btn-sm btn-primary">+ Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subdomain</th>
                                <th>Units</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($recent_orgs as $org)
                        <tr>
                            <td><strong>{{ $org->name }}</strong></td>
                            <td><code>{{ $org->slug }}.lipakodi.co.ke</code></td>
                            <td>{{ $org->total_units }}</td>
                            <td><span class="org-status status-{{ $org->status }}">{{ ucfirst($org->status) }}</span></td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item">
                                            <a class="btn btn-sm btn-info btn-block" href="{{ route('super.organizations.show', $org->id) }}"> View</a>
                                        </div>
                                        <div class="dropdown-item">
                                            <a class="btn btn-sm btn-success btn-block" href="{{ route('super.organizations.edit', $org->id) }}"> Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Subscription Plans --}}
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Subscription Plans</h3>
                <div class="card-options">
                    <a href="{{ route('super.plans.index') }}" class="btn btn-sm btn-primary">Manage Plans</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($plans as $plan)
                    <div class="col-xl-3 col-lg-3 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <svg class="card-custom-icon text-primary icon-dropshadow-primary" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                    <path d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156z"></path>
                                </svg>
                                <p class="mb-1">{{ $plan->name }}</p>
                                <h2 class="mb-1 font-weight-bold">KES {{ number_format($plan->price_per_unit) }}</h2>
                                <small class="text-muted">per unit/month &bull; {{ $plan->units_min }}{{ $plan->units_max ? ' - '.$plan->units_max : '+' }} units</small>
                                <div class="progress progress-sm mt-3 bg-primary-transparent">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
