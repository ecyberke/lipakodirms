@extends('landlord.layouts.master')
@section('title', 'Service Requests')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('includes.messages')
                <table id="sr-table" class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>Property</th>
                            <th>House No</th>
                            <th>Service Requested</th>
                            <th>Area Affected</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @forelse($requests as $req)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $req->apartment->name ?? 'N/A' }}</td>
                        <td>{{ $req->house->house_no ?? 'N/A' }}</td>
                        <td><strong>{{ $req->request_type }}</strong></td>
                        <td>{{ $req->area_affected ?? 'N/A' }}</td>
                        <td>
                            @if($req->approval == 1)
                                <span class="badge badge-success">Approved</span>
                            @elseif($req->status == 'notice')
                                <span class="badge badge-warning">Notice</span>
                            @else
                                <span class="badge badge-secondary">Pending</span>
                            @endif
                        </td>
                        <td>{{ $req->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted">No service requests found</td></tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $requests->links() }}
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
    $('#sr-table').DataTable({
        responsive: true,"pageLength": 25, "order": [[6, "desc"]]});
});
</script>
@endsection
