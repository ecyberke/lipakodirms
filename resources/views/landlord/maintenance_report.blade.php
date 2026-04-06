@extends('landlord.layouts.master')
@section('title', 'Maintenance Report')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="card">
        <form action="{{ route('landlord.maintenance-report') }}" method="GET">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        @include('includes.messages')
                        <div class="row">
                            <div class="col-sm-8">
                                <label>Select Property <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search" style="width:100%" name="apartment_id">
                                    <option selected disabled>-----Select-----</option>
                                    @foreach($apartments as $apt)
                                    <option value="{{ $apt->id }}" {{ request('apartment_id') == $apt->id ? 'selected' : '' }}>
                                        {{ $apt->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Month <span class="text-danger">*</span></label>
                                <input class="form-control" type="month" name="rent_month" value="{{ request('rent_month') }}">
                            </div>
                        </div><br>
                        <div class="row mb-4">
                            <div class="col-sm-8">
                                <button type="submit" name="generate" value="1" class="btn btn-success waves-effect waves-light">Get Report</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($hasMaintenanceReport ?? false)
    <div class="card" style="padding:25px;">
        <div class="row"><div class="col-12 text-center"><h2>Property Maintenance Report</h2></div></div>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Report Month:</strong> {{ request('rent_month') }}</p>
                            <p><strong>Property:</strong> {{ $selectedApartment->name ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-12 text-center"><h4>Maintenance Report</h4></div>
                    <div class="row table-responsive">
                        <table class="table dt-responsive nowrap" style="border-collapse:collapse;width:100%;">
                            <thead>
                                <tr>
                                    <th>House No</th>
                                    <th>Service Type</th>
                                    <th>Area Affected</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($maintenanceRequests as $req)
                            <tr>
                                <td>{{ $req->house->house_no ?? 'N/A' }}</td>
                                <td>{{ $req->request_type }}</td>
                                <td>{{ $req->area_affected ?? 'N/A' }}</td>
                                <td>{{ $req->description }}</td>
                                <td>
                                    @if($req->approval == 1)
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-secondary">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $req->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted">No maintenance records found</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection
