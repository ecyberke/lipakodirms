@extends('layouts.master')
@section('css')
<!-- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- File Uploads css -->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!-- Time picker css -->
<link href="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
<!-- Date Picker css -->
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
<!-- File Uploads css-->
 <link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!--Mutipleselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">
<!--Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
<!--intlTelInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.css')}}">
<!--Jquerytransfer css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css')}}">
<!--multi css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multi/multi.min.css')}}">
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<!--<div class="page-leftheader">-->
							<!--	<h4 class="page-title">Advanced Foms</h4>-->
							<!--</div>-->
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ route('home')}}" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<!--<li class="breadcrumb-item"><a href="#">Forms</a></li>-->
									<li class="breadcrumb-item active" aria-current="page">Edit Bill</li></li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<!-- Row -->
						<div class="row">
							<div class="col-lg-12 col-md-12">
							    <form action="{{route('bill.store')}}" method="post" class="card">
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
                            <label>Edit Bill<span class="text-danger">*</span></label>
                            <select id="billSelector" class="form-control select2-show-search" style="width: 100%"  name="type">

                                <option value="{{$payowners->type}}">{{$payowners->type}}</option>
                                <option value="serviceRequest">Service Requests</option>
                                <option value="Litter Collection">Litter Collection</option>
                                <option value="Compund Cleaning and Maintenance">Compound Cleaning and Maintenance</option>
                                <option value="Electricity and Water">Electricity and Water</option>
                                <option value="Others">Others</option>
                                <option value="agency">Agency </option>
                                
                           

                            </select>
                            </div></div> <br>
                            <div class="row">
                                @if($payowners->bill_type === 'property')
                                <div class="col-sm-6 conditionalSections" id="serviceRequestSection">
                                    <div class="form-group">
                                        <label> Select a Request<span class="text-danger">*</span></label>
                                        <div>
                                            <select class="form-control select2-show-search" style="width: 100%"  name="apartment_id">

                                                <option value="{{$payowners->apartment_id}}">{{$payowners->apartment->name}}</option>
                                                @forelse ($service_requests as $test)
                                            <option value="{{$test->apartment->id}}">Service Request - {{$test->id}}</option>
                                                    @empty
                
                                                    @endforelse
                
                                            </select>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 conditionalSections" id="apartmentSection">
                                    <div class="form-group">
                                        <label> Apartment<span class="text-danger">*</span></label>
                                        <div>
                                            <select class="form-control select2-show-search" style="width: 100%"  name="apartment_id">

                                                 <option value="{{$payowners->apartment_id}}">{{$payowners->apartment->name}}</option>
                                                @forelse ($apartments as $apartment=>$key)
                                            <option value="{{$key}}">{{$apartment}}</option>
                                                    @empty
                
                                                    @endforelse
                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="col-sm-6 conditionalSections" id="agencySection">
                                    <div class="form-group">
                                        <label> Agency User</label>
                                        <div>
                                            
                                            {{-- @forelse ($users as $user) --}}
                                            <input class="form-control " type="text" id="example-text-input" name="agency_user"
                                        value="{{ Auth::user()->name}}" readonly>
                                        {{-- @empty
                
                                                    @endforelse --}}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Amount<span class="text-danger">*</span></label>
                                            <div>
                                                <div class="form-group">
                                                   
                                                        <input class="form-control " type="text" id="example-text-input" name="bill_amount"
                                                value="{{$payowners->total_owned}}">
                                                   
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                
                                
                                
                                
                                
                            </div>
                            
                             <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Bill Description <span class="text-danger">*</span></label>
                                                    <textarea name="bill_description" class="form-control" rows="6" value="{{payowners->description}}"  ></textarea>
                                                        
                                                    </div>
                                        </div><br>
                            
                    
                           
                           
                                                
                                                        
                                        
                      
                         
                                

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Edit Bill</button></button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
							

								
							</div>
						
					</div>
			
@endsection
@section('js')
<!--Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!-- Timepicker js -->
<script src="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
<script src="{{URL::asset('assets/plugins/time-picker/toggles.min.js')}}"></script>
<!-- Datepicker js -->
<script src="{{URL::asset('assets/plugins/date-picker/date-picker.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>
<!--File-Uploads Js-->
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
<!-- File uploads js -->
<script src="{{URL::asset('assets/plugins/fileupload/js/dropify.js')}}"></script>
<script src="{{URL::asset('assets/js/filupload.js')}}"></script>
<!-- Multiple select js -->
<script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
<!--Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<!--intlTelInput js-->
<script src="{{URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.js')}}"></script>
<script src="{{URL::asset('assets/plugins/intl-tel-input-master/country-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/intl-tel-input-master/utils.js')}}"></script>
<!--jquery transfer js-->
<script src="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.js')}}"></script>
<!--multi js-->
<script src="{{URL::asset('assets/plugins/multi/multi.min.js')}}"></script>
<!-- Form Advanced Element -->
<script src="{{URL::asset('assets/js/formelementadvnced.js')}}"></script>
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script src="{{URL::asset('assets/js/file-upload.js')}}"></script>
<script>
    $(document).ready(function () {
        var x = document.getElementById("billSelector").value;
        var y = document.getElementById("billTypeSelector").value;
        $("#serviceRequestSection").hide();
        $("#apartmentSection").hide();
        $("#agencySection").hide();
        $('#billSelector').hide();
        if ( y == 'property')
        {
            $("#billSelector").show();
        }
        else {
            $("#agencySection").show();
        }
    });

    $('#billTypeSelector').change(function(){
        var x = document.getElementById("billTypeSelector").value;
        $("#propertyBillsInput").hide();
        $("#agencySection").hide();
        $('#serviceRequestSection').hide();
        if ( x == 'property'){
            $("#propertyBillsInput").show();
            $('#serviceRequestSection').show();
        }else if(x == 'agency'){
            $("#agencySection").show();
        }
    });
    $('#billSelector').change(function(){
        var x = document.getElementById("billSelector").value;
        $("#serviceRequestSection").hide();
        $("#apartmentSection").hide();
        
        $("#agencySection").hide();
        if ( x == 'serviceRequest')
        {
            $("#serviceRequestSection").show();
        }else if ( x == 'agency'){
            $("#agencySection").show();
        } else{
            $("#apartmentSection").show();
        }
    });
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
@endsection

