@extends('tenant.layouts.master')
@section('title', 'My Statement')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <!-- Filter Form - same as company -->
    <div class="card">
        <form action="{{ route('tenant.statement') }}" method="GET">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        @include('includes.messages')
                        <div class="row">
                            <div class="col-sm-6">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control" type="date" name="from"
                                            value="{{ $from ?? '' }}" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control" type="date" name="to"
                                            value="{{ $to ?? '' }}" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-8">
                                <button type="submit" name="generate" value="1"
                                    class="btn btn-success waves-effect waves-light">
                                    Get Statement
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($hasReport)
    <div class="card" style="padding:25px;">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>TENANT STATEMENT</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Tenant Name:</strong> <span>{{ $other_info['name'] }}</span></p>
                            <p><strong>Telephone:</strong> <span>{{ $other_info['phone'] }}</span></p>
                            <p><strong>Tenant Account Number:</strong> <span>{{ $other_info['acc_number'] }}</span></p>
                            <p><strong>House Number:</strong> <span>{{ $other_info['house_no'] }}</span></p>
                            <p><strong>Property:</strong> <span>{{ $other_info['apartment_name'] }}</span></p>
                            <p><strong>Property Owner:</strong> <span>{{ $other_info['landlord_name'] }}</span></p>
                            <p><strong>Date of Statement:</strong> <span>{{ $other_info['date'] }}</span></p>
                            <p><strong>Statement Period:</strong> <span>{{ $other_info['from_to'] }}</span></p>
                        </div>
                        <div class="col-xs-6 float-right" style="float:right;text-align:right;">
                            <div class="mt-3 float-right">
                                @if($org && $org->logo)
                                <img src="{{ asset('storage/'.$org->logo) }}" alt="{{ $org->name }}" height="80">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="title text-center"><h4>Detailed Statement</h4></div>
                    </div>

                    <div class="row table-responsive">
                        <table class="table dt-responsive nowrap" style="border-collapse:collapse;width:100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($entries as $entry)
                            <tr>
                                <th>{{ $entry['date'] }}</th>
                                <td>{{ $entry['description'] }}</td>
                                <td>{{ $entry['reference'] }}</td>
                                <td>{{ $entry['amount'] === '-' ? '-' : number_format($entry['amount'], 2) }}</td>
                                <td>{{ $entry['paid_in'] === '-' ? '-' : number_format($entry['paid_in'], 2) }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <div class="title text-center"><h4>Summary</h4></div>
                    </div>

                    <div class="row table-responsive">
                        <table class="table dt-responsive nowrap" style="border-collapse:collapse;width:100%;">
                            <thead>
                                <tr><td>Details</td><td>Amount</td><td>Payment</td></tr>
                            </thead>
                            <tbody>
                                <tr><td>Deposit</td><td>{{ $deposit_sum }}</td><td>-</td></tr>
                                <tr><td>Electricity Deposit</td><td>{{ $electricity_deposit_sum }}</td><td>-</td></tr>
                                <tr><td>Rent</td><td>{{ $rent_sum }}</td><td>-</td></tr>
                                <tr><td>Others (Arrears & Bills)</td><td>{{ $others_sum }}</td><td>-</td></tr>
                                <tr><td>Payments</td><td>-</td><td>{{ $payments }}</td></tr>
                                <tr><th>Total</th><th>{{ $total }}</th><th>{{ $payments }}</th></tr>
                                <tr><th>Balance</th><th colspan="2">{{ $balance }}</th></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ request()->fullUrl() }}&download=yes" target="_blank"
                               class="m-2 btn btn-success waves-effect waves-light">
                                Download Statement
                            </a>
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
<script src="{{URL::asset('assets/plugins/date-picker/date-picker.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
@endsection
