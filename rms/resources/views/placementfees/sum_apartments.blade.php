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
        <div class="col-sm-12">
            <h4 class="page-title">Sum Of Placement Fees Per Apartment / Monthly Basis</h4>
        </div>
    </div>

    <div class="row filter-row mb-5">     
        <div class="col-3">
            <div class="form-group form-focus select-focus">
                <select class="select floating" name="month" id="month">
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

                    <table id="deposits-table" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>HOUSE</th>
                                <th>TOTAL DEPOSITS</th>                                
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
       

         var oTable = $('#deposits-table').DataTable({
             processing: true,
             serverSide: true,
             ajax: {
                 method: 'GET',
                 url: '{!! route('api.deposits.sum') !!}',
                  data: function (d) {                   
                     d.month = $("#month option:selected").val();
                     d.year = $("#year option:selected").val();                    
                 }
             },
             columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},
                 { data: 'house', name: 'house' },
                 { data: 'amount', name: 'amount' },
                            
              
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