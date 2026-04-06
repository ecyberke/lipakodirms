@extends('super_admin.layouts.master')
@section('title', 'Subscriptions')
@section('page-title', 'All Subscriptions')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="sub-table" class="table table-striped custom-table mb-0 dt-responsive nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Organization</th>
                                <th>Plan</th>
                                <th>Billing Cycle</th>
                                <th>Units</th>
                                <th>Amount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($subscriptions as $sub)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <strong>{{ $sub->organization->name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $sub->organization->slug ?? '' }}.lipakodi.co.ke</small>
                            </td>
                            <td>{{ $sub->plan->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $sub->billing_cycle)) }}</td>
                            <td>{{ $sub->units }}</td>
                            <td>KES {{ number_format($sub->amount) }}</td>
                            <td>{{ $sub->starts_at ? \Carbon\Carbon::parse($sub->starts_at)->format('d M Y') : 'N/A' }}</td>
                            <td>{{ $sub->ends_at ? \Carbon\Carbon::parse($sub->ends_at)->format('d M Y') : 'N/A' }}</td>
                            <td><span class="org-status status-{{ $sub->status }}">{{ ucfirst($sub->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted">No subscriptions found</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $subscriptions->links() }}
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
$(function() {
    $('#sub-table').DataTable({ responsive: true, pageLength: 25, order: [[0, 'desc']], paging: false });
});
</script>
@endsection
