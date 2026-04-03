@extends('layouts.home')

@push('header_scripts')
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">

@endpush

@section('content')
<div class="content container-fluid">

    <!-- Page Title -->
    <div class="row">
        {{-- <div class="col-sm-12">
            <h4 class="page-title">Assign A Room To Tenant</h4>
        </div> --}}
    </div>
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="card">
    <form action="{{ route('expenses.store')}}" method="post">
        @csrf
        
        
        <div class="row">
            {{ csrf_field() }}

            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        {{-- <h4 class="mt-0 header-title mb-4">Important Details</h4> --}}

                        {{-- <hr class="mt-2 mb-4"> --}}
                        @include('includes.messages')
                                  
                 
                    
                        <div class="row">
                            <div class="col-sm-6">
                            <label>Expense Type <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="type" readonly
                                            value="General Agency Expense"> 
                            </div>
                            
                                <div class="col-sm-6">
                                    <label>Expense Date  <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="requested_date"
                                    value="{{ old('requested_date')}}">
                                    </div> 
                                    </div>
                                
                        </div> <br>
                        {{-- <div class="row"> --}}
                            <div class="row">
                                
                                <div class="col-sm-12">
                                    <label>Expense Description<span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="3" cols="66" ></textarea>
                                    </div>
                            </div>
                              
                            
                        {{-- </div>  <br> --}} <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Amount (Ksh.)<span class="text-danger">*</span></label>
                                <input type="text" name="amount" class="form-control" value="" >
                                </div>
                            <div class="col-sm-6">
                                <label>Payment Status<span class="text-danger">*</span></label>
                                <select class="select"  name="status">

                                    <option selected style="color:white;">
                                   --select-- 
                                    </option>
                                    <option value="0">unpaid</option>
                                    <option value="2">Partial</option>
                                    <option value="1">Paid</option>

                                </select>
                                </div>
                           
                        </div><br>
                                                                  
                                
                               

                        <div class="row mb-4">
                            <div class="col-sm-8 ">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Add Expense</button></button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
    
    </div>


    <!-- /Content End -->

</div>
@endsection

@push('footer_scripts')
<script>
    $('#apartment_id').change(function () {
       var id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{!! route('ajax.houses.occupied') !!}",
            method: 'POST',
            data: { 'id': id, '_token': token },
            success: function (data) {
                $('#house-rent').val('');
                $('#section-bills').html('');
                $("select[name='house_id']").html('');
                $("select[name='house_id']").html(data.options);
            },
            error: function () {
                alert("error!!!!");
            }
        });
    });

    $('#houses_select').change(function () {
        var id = $(this).val();
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{!! route('ajax.house.bills') !!}",
            method: 'POST',
            data: { 'id': id, '_token': token },
            success: function (data) {
                $('#house-rent').val('');
                $('#house-rent').val(data.house_rent);
            },
            error: function () {
                alert("error!!!!");
            }
        });

    });

    $(document).on('change', '#off-switch', function () {
        if ($(this).prop("checked") == true) {
            $("#new-tenant-row").prop('hidden', false);
            $("#checked-tenant").attr("name", "is_new_tenant");
        }
        else {
            $("#new-tenant-row").prop('hidden', true);
            $("#checked-tenant").removeAttr('name');
        }
    });

    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'MM/YYYY'
        });
    });

    $(document).on('focusout', '#tenant-id', function () {

        var id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{!! route('ajax.tenant.validate') !!}",
            method: 'POST',
            data: { 'id': id, '_token': token },
            success: function (data) {

                if (data.exists) {
                    $('#tenant-names').removeClass('is-invalid');
                    $('#tenant-names').addClass('is-valid');
                    $('#tenant-names').val('');
                    $('#tenant-names').val(data.tenant_name);
                } else {
                     $('#tenant-names').removeClass('is-valid');
                     $('#tenant-names').addClass('is-invalid');
                    $('#tenant-names').val('');
                    $('#tenant-names').val(data.tenant_name);
                }

            },
            error: function () {
                alert("error!!!!");
            }
        });

    });

</script>
@endpush