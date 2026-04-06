@extends('super_admin.layouts.master')
@section('title', 'Organizations')
@section('page-title', 'All Agencies / Landlords')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">

    {{-- Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('includes.messages')
                    <table id="org-table" class="table table-striped custom-table mb-0 dt-responsive nowrap"
                        style="border-collapse:collapse;border-spacing:0;width:100%;">
                        <thead>
                            <tr>
                                <th style="width:3%">#</th>
                                <th style="width:25%">Organization</th>
                                <th style="width:20%">Subdomain</th>
                                <th style="width:8%">Type</th>
                                <th style="width:8%">Units</th>
                                <th style="width:10%">Status</th>
                                <th style="width:15%">Subscription</th>
                                <th style="width:5%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script>
$(function() {
    $('#org-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, 'desc']],
        ajax: '{!! route('super.api.organizations') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name_email', name: 'name', orderable: true },
            { data: 'subdomain', name: 'slug', orderable: true },
            { data: 'type', name: 'type' },
            { data: 'total_units', name: 'total_units' },
            { data: 'status_badge', name: 'status', orderable: true },
            { data: 'subscription_info', name: 'subscription_info', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
