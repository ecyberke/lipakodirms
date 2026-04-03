@extends('layouts.master')


@push('header_scripts')
<!-- DataTables -->
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                {{-- <h3 class="page-title">Property Details</h3> --}}
                {{-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Property</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ul> --}}
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    @include('includes.messages')

    <div class="row">
        <div class="col-md-8">
            <div class="job-info job-widget">
                <h3 class="job-title">{{ $apartment->name }}</h3>
                <ul class="job-post-det mb-2">
                    <li><i class="fa fa-calendar"></i> Registered Date: <span
                            class="text-blue">{{ $apartment->created_at->diffForHumans() }}</span></li>
                    <li><i class="fa fa-home"></i> Total Houses: <span
                            class="text-blue">{{ $apartment->houses->count() }}</span></li>
                </ul>
            </div>
            <div class="job-content job-widget">
                <div class="job-desc-title">
                    <h4>Property Houses</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="houses-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hous</th>
                                <th>Type</th>
                                {{-- <th>Status</th> --}}
                                <th>Rent</th>
                                {{-- <th>..</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-md-4 order-first">
            <div class=" card">
                <div class="card-body">
                    <div class="info-list">
                        <span><i class="fa fa-bar-chart"></i></span>
                        <h5>Type</h5>
                        <p> {{ $apartment->type}}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-money"></i></span>
                        <h5>Town</h5>
                        <p>{{ $apartment->town}}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-suitcase"></i></span>
                        <h5>Location</h5>
                        <p>
                            {{ $apartment->location }}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-ticket"></i></span>
                        <h5>Managent Fee</h5>
                        <p>{{ $apartment->management_fee_percentage}} %</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-user"></i></span>
                        <h5>Owner</h5>
                        <p>{{ $apartment->landlord->full_name}}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-map-signs"></i></span>
                        <h5>Description</h5>
                        <p> {{ $apartment->description }}</p>
                    </div>
                    <hr class="pt-4">

                    {{-- <div class="row py-3">
                        <div class="col-6 align-end">
                            <a class="btn btn-info btn-sm " href="{{ route('apartment.edit',$apartment->id)}}">Edit
                                Property</a>
                        </div>
                        <div class="col-6 ">

                            @if (Auth::user()->is_admin || Auth::user()->is_super)
                                <form action="{{ route('apartment.delete',$apartment->id) }}" method="post"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-sm  btn-block btn-danger">
                            </form>
                            @endif                            
                        </div>
                    </div> --}}

                </div>


            </div>
        </div>
        <input type="hidden" data-fetch-route="{{ route('api.apartment.houses', $apartment->id ) }}" id="invoicesFetch">
    </div>


</div>

@endsection

@push('footer_scripts')
<!-- Required datatable js -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Responsive examples -->
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function () {
        $(document).ready(function () {
            $('#invoices-table').DataTable(
                {
                    "pageLength": 4,
                    "bLengthChange": false
                }
            );
        });
    });

    $(function () {

        var $data_route = $("#invoicesFetch").attr('data-fetch-route');

        console.log($data_route);
        $('#houses-table').DataTable({
            "pageLength": 3,
            "bLengthChange": true,
            processing: true,
            serverSide: true,
            ajax: $data_route,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'house_no', name: 'house_no' },
                { data: 'house_type', name: 'house_type' },
                // { data: 'id', name: 'id' },
                { data: 'rent', name: 'rent' },
                //{ data: 'id', name: 'id' },

            ]
        });
    });

    $(document).on('submit', '.delete-form', function (event) {
        return confirm('Deleting apartment will also delete all associated houses attached to it.Are you sure ?');
        event.preventDefault();
    });
</script>

@endpush