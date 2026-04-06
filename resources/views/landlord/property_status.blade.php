@extends('landlord.layouts.master')
@section('title', 'Property Status')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="card">
        <form action="{{ route('landlord.property-status') }}" method="GET">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        @include('includes.messages')
                        <div class="row">
                            <div class="col-sm-8">
                                <label>Select Property <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search" style="width:100%" name="apartment_id">
                                    <option value="" selected>--- All Properties ---</option>
                                    @foreach($apartments as $apt)
                                    <option value="{{ $apt->id }}" {{ request('apartment_id') == $apt->id ? 'selected' : '' }}>
                                        {{ $apt->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Get Report</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @foreach($apartments as $apt)
    @if(!request('apartment_id') || request('apartment_id') == $apt->id)
    <div class="card mb-4" style="padding:25px;">
        <div class="row">
            <div class="col-12 text-center"><h2>Property Status Report</h2></div>
        </div>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Property Name:</strong> {{ $apt->name }}</p>
                            <p><strong>Location:</strong> {{ $apt->location }}</p>
                            <p><strong>Date:</strong> {{ date('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="col-12 text-center"><h4>House Status</h4></div>
                    <div class="row table-responsive">
                        <table class="table dt-responsive nowrap" style="border-collapse:collapse;width:100%;">
                            <thead>
                                <tr>
                                    <th>House No</th>
                                    <th>Type</th>
                                    <th>Rent</th>
                                    <th>Tenant</th>
                                    <th>Account No</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($apt->houses as $house)
                            @php
                                $ht = $house->house_tenant;
                                $tenant = $ht ? \App\Tenant::find($ht->tenant_id) : null;
                            @endphp
                            <tr>
                                <td><strong>{{ $house->house_no }}</strong></td>
                                <td>{{ $house->house_type ?? 'N/A' }}</td>
                                <td>{{ $org->currency ?? 'KES' }} {{ number_format($house->house_rent ?? 0) }}</td>
                                <td>{{ $tenant?->full_name ?? 'Vacant' }}</td>
                                <td>{{ $tenant?->account_number ?? '-' }}</td>
                                <td>
                                    @if($house->on_notice)
                                        <span class="badge badge-warning">On Notice</span>
                                    @elseif($house->is_occupied)
                                        <span class="badge badge-success">Occupied</span>
                                    @else
                                        <span class="badge badge-danger">Vacant</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted">No units</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection
