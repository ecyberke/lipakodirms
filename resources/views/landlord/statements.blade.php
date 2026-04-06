@extends('landlord.layouts.master')
@section('title', 'Statement')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="card">
        <form action="{{ route('landlord.statements') }}" method="GET">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        @include('includes.messages')
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Select Property <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search" style="width:100%" name="owner_id" required>
                                    <option selected disabled>-----Select-----</option>
                                    @foreach($apartments as $apt)
                                    <option value="{{ $apt->id }}" {{ request('owner_id') == $apt->id ? 'selected' : '' }}>
                                        {{ $apt->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control" type="date" name="from" value="{{ request('from') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control" type="date" name="to" value="{{ request('to') }}">
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="row mb-4">
                            <div class="col-sm-8">
                                <button type="submit" name="generate" value="1" class="btn btn-success waves-effect waves-light">Get Statement</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($hasReport ?? false)
    <div class="card" style="padding:25px;">
        <div class="row">
            <div class="col-12 text-center"><h2>Property Owner Statement</h2></div>
        </div>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Property Owner:</strong> {{ $landlord->full_name }}</p>
                            <p><strong>Property:</strong> {{ $selectedApartment->name ?? '' }}</p>
                            <p><strong>Phone:</strong> {{ $landlord->phone }}</p>
                            <p><strong>Period:</strong> {{ request('from') }} to {{ request('to') }}</p>
                            <p><strong>Date:</strong> {{ date('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="col-12 text-center"><h4>Payment Records</h4></div>
                    <div class="row table-responsive">
                        <table class="table dt-responsive nowrap" style="border-collapse:collapse;width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>House No</th>
                                    <th>Month</th>
                                    <th>Rent</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $i = 1; $totalRent = 0; $totalPaid = 0; $totalBal = 0; @endphp
                            @foreach($payments as $pay)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $pay->house->house_no ?? 'N/A' }}</td>
                                <td>{{ $pay->rent_month }}</td>
                                <td>{{ $org->currency ?? 'KES' }} {{ number_format($pay->rent ?? 0) }}</td>
                                <td>{{ $org->currency ?? 'KES' }} {{ number_format($pay->paid_in ?? 0) }}</td>
                                <td>{{ $org->currency ?? 'KES' }} {{ number_format($pay->balance ?? 0) }}</td>
                                <td>{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y') }}</td>
                            </tr>
                            @php $totalRent += $pay->rent ?? 0; $totalPaid += $pay->paid_in ?? 0; $totalBal += $pay->balance ?? 0; @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 text-center"><h4>Summary</h4></div>
                    <div class="row">
                        <table class="table table-striped">
                            <tr><td>Total Rent</td><td>{{ $org->currency ?? 'KES' }} {{ number_format($totalRent) }}</td><td>-</td></tr>
                            <tr><td>Total Paid</td><td>-</td><td>{{ $org->currency ?? 'KES' }} {{ number_format($totalPaid) }}</td></tr>
                            <tr><th>Balance</th><th>{{ $org->currency ?? 'KES' }} {{ number_format($totalBal) }}</th><th>-</th></tr>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ request()->fullUrl() }}&download=yes" target="_blank"
                               class="m-2 btn btn-success waves-effect waves-light">Download Statement</a>
                        </div>
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
<script src="{{URL::asset('assets/plugins/date-picker/date-picker.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
@endsection
