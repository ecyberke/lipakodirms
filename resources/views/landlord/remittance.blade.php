@extends('landlord.layouts.master')
@section('title', 'Remittance')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('includes.messages')
                    <table id="remit-table" class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th style="width:5%">#</th>
                                <th>Property</th>
                                <th>Period</th>
                                <th>Total Amount</th>
                                <th>Property Bills</th>
                                <th>Management Fees</th>
                                <th>Total Remitted</th>
                                <th>Transaction Code</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($remittances as $rem)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $rem->apartment->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($rem->rent_month)->format('M Y') }}</td>
                            <td>{{ $org->currency ?? 'KES' }} {{ number_format($rem->total_owned ?? 0) }}</td>
                            <td>{{ $org->currency ?? 'KES' }} {{ number_format($rem->bills ?? 0) }}</td>
                            <td>{{ $org->currency ?? 'KES' }} {{ number_format($rem->mgt ?? 0) }}</td>
                            <td class="text-success font-weight-bold">{{ $org->currency ?? 'KES' }} {{ number_format($rem->paid_in ?? 0) }}</td>
                            <td>{{ $rem->description ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($rem->created_at)->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted">No remittance records found</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script>
$(function() { $('#remit-table').DataTable({
        responsive: true,"pageLength": 25, "order": [[8, "desc"]]}); });
</script>
@endsection
