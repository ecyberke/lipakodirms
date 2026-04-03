@extends('layouts.home')

@push('header_scripts')
<!-- DataTables -->
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="content container-fluid">

    <div class="row mb-3">
        <div class="col-sm-6">
            <h4 class="">Unpaid Invoices</h4>
        </div>
    </div>

    <div class="row filter-row mb-5">    
        <div class="col-3">
            <div class="form-group form-focus select-focus">
                <select class="select floating" name="month" id="month">
                    <option disabled selected>---Select---</option>
                    <option>Jan</option>
                    <option>Feb</option>
                    <option>Mar</option>
                    <option>Apr</option>
                    <option>May</option>
                    <option>Jun</option>
                    <option>Jul</option>
                    <option>Aug</option>
                    <option>Sep</option>
                    <option>Oct</option>
                    <option>Nov</option>
                    <option>Dec</option>
                </select>
                <label class="focus-label">Select Month</label>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group form-focus select-focus">
                <select class="select floating" name="year" id="year">
                    <option disabled selected>----Select---</option>
                    @for ($i = 2019; $i < 2026 ; $i++) <option>{{ $i}}</option>
                        @endfor
                </select>
                <label class="focus-label">Select Year</label>
            </div>
        </div>

        <div class="col-2">
            <a href="#" class="btn btn-success btn-block" id="btn-search"> Search </a>
        </div>
    </div>
    <!-- /Search Filter -->

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title"></h4>
                    </p>
                    <div class="row py-3">
                        {{-- <div class="col-3 align-end">
                            <a class="btn btn-danger btn-sm" href="/penalize-invoice">Penalize Invoices</a>
                        </div>&nbsp;&nbsp; --}}
                        {{-- <div class="">
                            <a class="btn btn-success btn-sm " href="{{ route('house.occupied')}}">Occupied</a>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <div class="">
                            <a class="btn btn-info btn-sm" href="{{ route('house.list')}}">All Houses</a>
                        </div> --}}
                        
                    </div>

                    <table id="unpaid-invoices-table" class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                     <th style="width:10%">#INV</th>
                                    <th>House</th>
                                    <th>Tenant</th>
                                    <th>Rent</th>
                                    <th>Monthly Bills</th>
                                    <th>Penalty</th>
                                    <th>Total Payable</th>                                    
                                    <th>Paid In</th>                                    
                                    <th>Balance</th>                                    
                                    <th>Action</th>                                   
                                    
                                </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

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
         

        var oTable = $('#unpaid-invoices-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                method: 'GET',
                url: '{!! route('api.invoice.unpaid') !!}',
                 data: function (d) {
                    d.token = $("input[name='_token']").val();
                    d.month = $("#month option:selected").val();
                    d.year = $("#year option:selected").val();                   
                }
            },
             columns: [            
                     { data: 'id', name: 'id' },
                     { data: 'house.house_no', name: 'house.house_no', orderable: false },
                     { data: 'tenant.full_name', name: 'tenant.full_name',orderable: false },
                     { data: 'rent', name: 'rent' },
                     { data: 'bills', name: 'bills' },
                     { data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                     { data: 'total_payable', name: 'total_payable', orderable: false, searchable: false },
                     { data: 'paid_in', name: 'paid_in', orderable: false, searchable: false },
                     { data: 'balance', name: 'balance', orderable: false, searchable: false },
                     { data: 'action', name: 'action',orderable: false, searchable: false  },                  
                             ]
        });

        $('#btn-search').on("click", function (event) {
                oTable.draw();
                event.preventDefault();
         });


    });
</script>
<!-- Datatable init js -->
{{-- <script src="assets/pages/datatables.init.js"></script> --}}
@endpush