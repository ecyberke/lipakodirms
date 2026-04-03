@extends('layouts.home')

@push('header_scripts')
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


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
    <form action="{{ route('servicerequests.store')}}" method="post">
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
                            <div class="col-sm-12">
                            <label>Select Tenant  <span class="text-danger">*</span></label>
                            <select class="js-example-basic-single select" style="width: 100%"  name="tenant_id">

                                <option selected disabled>-----Select-----</option>
                                @forelse ($tenants as $tenant=>$key)
                                    <option value="{{$key}}">{{ $tenant}}</option>
                                    @empty

                                    @endforelse

                            </select>
                            </div></div> <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Select Property <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single select" style="width: 100%" id="apartment_id" name="apartment_id">

                                        <option selected disabled>-----Select-----</option>

                                        @forelse ($apartments as $apartment=>$key)
                                        <option value="{{$key}}">{{ $apartment}}</option>
                                        @empty

                                        @endforelse

                                    </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Select House </label>
                                        <select class="js-example-basic-single select" style="width: 100%" name="house_id" >

                                        </select>
                                        </div>
                            </div>
                                <br>
                             <div  class="row">
                                <div class="col-sm-6">
                                    <label>Expense Type <span
                                        class="text-danger">*</span></label>
                                        <select class="js-example-basic-single select " style="width: 100%"  name="service_request">

                                            <option selected disabled >-----Select-----</option>
        
                                          
                                            <option value="General Property Expense">General Property Expense</option>
                                            <option value="Electricity Bills">Electricity Bills</option>
                                            <option value="Water Bills">Water Bills</option>
                                            <option value="Litter Collection">Litter Collection</option>
                                            <option value="Compound Cleaning and Maintenance">Compound Cleaning and Maintenance</option>
                                            
        
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Expense Date<span
                                            class="text-danger">*</span></label>
                                            <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" name="requested_date"
                                            value="{{ old('requested_date')}}">
                                            </div>
                                        </div>
                             </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Service Status</label>
                                                    <select class="js-example-basic-single select" style="width: 100%"  name="status">

                                                        <option selected disabled>-----Select-----</option>
                    
                                                      
                                                        <option value="0">Open</option>
                                                        <option value="2">In Progress</option>
                                                        <option value="1">Closed</option>
                    
                                                    </select>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Transaction Code</label>
                                                        <input type="text" name="transaction_code" class="form-control" value="" >
                                                    </div>
                                        </div><br>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Amount (Ksh.)</label>
                                                            <input type="text" name="amount" class="form-control" value="" >
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label>Payment Status</label>
                                                            <select class="js-example-basic-single select" style="width: 100%"  name="pay_status">

                                                                <option selected>
                                                                --select--
                                                                </option>
                                                                <option value="0">unpaid</option>
                                                                <option value="2">Partial</option>
                                                                <option value="1">Paid</option>
                            
                                                            </select>
                                                            </div>
                                                </div><br>
                                                        
                                
                      
                         
                                

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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

    
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
@endpush