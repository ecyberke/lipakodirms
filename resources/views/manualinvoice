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
    <form action="{{ route('tenant.allocate')}}" method="post">
        @csrf
        
        
        <div class="row">
            {{ csrf_field() }}

            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        {{-- <h4 class="mt-0 header-title mb-4">Important Details</h4> --}}

                        {{-- <hr class="mt-2 mb-4"> --}}
                        @include('includes.messages')
                        {{-- <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Tenant
                                ID Number <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="tenant-id" name="tenant_id"
                                    value="{{old('tenant_id')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Tenant
                                Name</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="tenant-names" readonly>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-sm-6">
                            <label >Select Tenant <span class="text-danger">*</span></label>
                          
                            
                                <select class="js-example-basic-single select" style="width: 100%" name="tenant_id">

                                    <option selected disabled>-----Select-----</option>
                                    @forelse ($tenants as $tenant=>$key)
                                        <option value="{{$key}}">{{ $tenant}}</option>
                                        @empty

                                        @endforelse

                                </select>
                            </div>
                            <div class="col-sm-6">
                            <label >Select Property <span class="text-danger">*</span></label>
                              
                                
                                    <select class="js-example-basic-single select" style="width: 100%" id="apartment_id" name="apartment">

                                        <option selected disabled>-----Select-----</option>

                                        @forelse ($apartments as $apartment=>$key)
                                        <option value="{{$key}}">{{ $apartment}}</option>
                                        @empty

                                        @endforelse

                                    </select>
                                </div>
                        </div><br>
                      
                           
                       
                            <div class="row">
                                <div class="col-sm-6">
                                <label >Select House<span class="text-danger">*</span></label>
                               
                                
                                    <select class="js-example-basic-single select" style="width: 100%" name="house_id" id="houses_select">

                                    </select>
                                </div>
                                <div class="col-sm-6">
                                <label >Monthly
                                    Rent</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Ksh</span>
                                        </div>
                                
                                    <input class="form-control" type="text" id="house-rent"  readonly>
                                    </div>
                                </div>
                            </div><br>

                        <div class="row">
                            <div class="col-sm-6">
                                <label >Rent to Pay</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Ksh</span>
                                        </div>
                                
                                    <input class="form-control" type="number" id="house-rent" name="rent" >
                                    </div>
                                </div>
                            <div class="col-sm-6">
                            <label >Deposit Amount</label>
                            

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ksh</span>
                                    </div>
                                    <input type = "number" class= "form-control"
                                           placeholder = "" name = "deposit_amount"
                                           value       = "{{ old('deposit_amount') ?? 0 }}" aria-describedby = "depositHelp">
                                        
                                </div>
                                <span class="form-text text-muted text-info">Defaults to " 0 " if no deposit was collected.</span>
                            </div>
                             </div><br>

                        {{-- <div   class = "form-group row">
                        <label for   = "example-text-input" class = "col-sm-4 col-form-label">Placement Fee<span
                               class = "text-danger">*</span></label>
                        <div   class = "col-sm-8">
                        <div   class = "input-group">
                        <div   class = "input-group-prepend">
                        <span  class = "input-group-text">Ksh</span>
                                    </div>
                                    <input type  = "text" class = "form-control" name = "rent_amount"
                                           value = "">
                                </div>
                                <span class="form-text text-muted text-info">Defaults to " 0 " if no placement fee was collected.</span>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-sm-6">
                            <label >Arrears Amount</label>
                            

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ksh</span>
                                    </div>
                                    <input type = "number" class= "form-control"
                                           placeholder = "" name = "arrears"
                                           value       = "" aria-describedby = "depositHelp">
                                        
                                </div>
                                <span class="form-text text-muted text-info">Defaults to " 0 " if no arrears input is done.</span>
                          
                            
                        </div>
                            <div class="col-sm-6">
                            <label>Placement Date <span
                                    class="text-danger">*</span></label>
                            
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" name="placement_date"
                                            value="{{ old('placement_date')}}">
                                    </div>
                                </div>

                            </div>
                        </div><br>
                        <div class="col-sm-12">
                                    <hr>
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-muted m-b-30 font-14">ADD BILLS
                                    </p>
                                </div>

                      <div class="row">
                            <div class="col-sm-6">
                            <label >Electricity & Waters</label>
                            

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ksh</span>
                                    </div>
                                    <input type = "number" class= "form-control"
                                           placeholder = "" name = "electricity_bill"
                                           value       = "" aria-describedby = "depositHelp">
                                        
                                </div>
                                <span class="form-text text-muted text-info">Defaults to " 0 " if no bill input is done.</span>
                          
                            
                        </div>
                            <div class="col-sm-6">
                            <label >Compound Cleaning and Maintenance</label>
                            

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ksh</span>
                                    </div>
                                    <input type = "number" class= "form-control"
                                           placeholder = "" name = "compound_bill"
                                           value       = "" aria-describedby = "depositHelp">
                                        
                                </div>
                                <span class="form-text text-muted text-info">Defaults to " 0 " if no bill input is done.</span>
                          
                            
                        </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-6">
                            <label >Litter Collection</label>
                            

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ksh</span>
                                    </div>
                                    <input type = "number" class= "form-control"
                                           placeholder = "" name = "litter_bill"
                                           value       = "" aria-describedby = "depositHelp">
                                        
                                </div>
                                <span class="form-text text-muted text-info">Defaults to " 0 " if no bill input is done.</span>
                          
                            
                        </div>
                            <div class="col-sm-6">
                            <label >Others</label>
                            

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ksh</span>
                                    </div>
                                    <input type = "number" class= "form-control"
                                           placeholder = "" name = "other_bill"
                                           value       = "" aria-describedby = "depositHelp">
                                        
                                </div>
                                <span class="form-text text-muted text-info">Defaults to " 0 " if no bill input is done.</span>
                          
                            
                        </div>
                        </div><br>
                       

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Assign House</button>
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
            url: "{!! route('ajax.houses.filter') !!}",
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
  
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
    </script> 
@endpush