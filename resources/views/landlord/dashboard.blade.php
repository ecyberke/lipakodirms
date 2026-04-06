@extends('landlord.layouts.master')
@section('title', 'Dashboard')

@section('content')
@if(!isset($landlord) || !$landlord)
    <div class="alert alert-warning">Your owner profile is not yet linked. Please contact management.</div>
@else

<!--Row-->
<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-success icon-dropshadow-success" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path>
                        </svg>
                        <p class="mb-1">Occupied Units</p>
                        <h2 class="mb-1 font-weight-bold">{{ $occupiedHouses }}</h2>
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
                            <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path>
                        </svg>
                        <p class="mb-1">Vacant Units</p>
                        <h2 class="mb-1 font-weight-bold">{{ $vacantHouses }}</h2>
                        <div class="progress progress-sm mt-3 bg-secondary-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 20%"></div>
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
                        <p class="mb-1">Total Units</p>
                        <h2 class="mb-1 font-weight-bold">{{ $totalHouses }}</h2>
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
                            <path d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156 M5.872,17.019h-2.89v-3.117h2.89V17.019zM9.587,17.019h-2.89V7.1h2.89V17.019z M13.303,17.019h-2.89v-6.651h2.89V17.019z M17.019,17.019h-2.891V2.982h2.891V17.019z"></path>
                        </svg>
                        <p class="mb-1">On Notice</p>
                        <h2 class="mb-1 font-weight-bold">{{ $onNoticeHouses }}</h2>
                        <div class="progress progress-sm mt-3 bg-orange-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Row-->
<div class="row row-deck">
    {{-- Houses on Notice --}}
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Houses on Notice</h3>
                <div class="card-options">
                    <a href="{{ route('landlord.property-status') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body overflow-hidden">
                <div class="h-400 scrollbar3" id="scrollbar3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-nowrap">
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>House No</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($onNoticeList as $house)
                            <tr>
                                <td>{{ $house->apartment->name ?? 'N/A' }}</td>
                                <td><strong>{{ $house->house_no }}</strong></td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center text-muted">No houses on notice</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Remittance --}}
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="card card-block">
            <div class="card-header d-sm-flex d-block">
                <h3 class="card-title">Recent Remittance</h3>
                <div class="ml-auto">
                    <a href="{{ route('landlord.remittance') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Period</th>
                                <th>Total Amount</th>
                                <th>Total Remitted</th>
                                <th>Ref</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($recentRemittances as $rem)
                        <tr>
                            <td>{{ $rem->apartment->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($rem->rent_month)->format('M Y') }}</td>
                            <td>{{ $org->currency ?? 'KES' }} {{ number_format($rem->total_owned ?? 0) }}</td>
                            <td class="text-success font-weight-bold">{{ $org->currency ?? 'KES' }} {{ number_format($rem->paid_in ?? 0) }}</td>
                            <td>{{ $rem->description ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">No remittance records yet</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Service Requests --}}
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Service Requests</h3>
                <div class="card-options">
                    <a href="{{ route('landlord.service-requests') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body overflow-hidden">
                <div class="h-400 scrollbar2" id="scrollbar2">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Property</th>
                                    <th>House No</th>
                                    <th>Service Requested</th>
                                    <th>Area Affected</th>
                                    <th>Request Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($serviceRequests as $req)
                            <tr>
                                <td>{{ $req->apartment->name ?? 'N/A' }}</td>
                                <td>{{ $req->house->house_no ?? 'N/A' }}</td>
                                <td><strong>{{ $req->request_type }}</strong></td>
                                <td>{{ $req->area_affected ?? 'N/A' }}</td>
                                <td>
                                    @if($req->approval == 0)
                                        <span class="badge badge-info">PENDING</span>
                                    @elseif($req->approval == 1)
                                        <span class="badge badge-success">APPROVED</span>
                                    @elseif($req->approval == 3)
                                        <span class="badge badge-secondary">AMEND</span>
                                    @else
                                        <span class="badge badge-danger">DECLINED</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">No recent service requests.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
