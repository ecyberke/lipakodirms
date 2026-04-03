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
									<li class="breadcrumb-item active" aria-current="page">Pay Bill</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<!-- Row -->
						<div class="row">
							<div class="col-lg-12 col-md-12">
							     @if (Auth::user()->is_admin==2)
					
							     <form action="{{ route('bill.payNow')}}" method="post" class="card">
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
                            <div class="col-md-12">
                                    <label>Bills Type <span class="text-danger">*</span></label>
                                    
                                    <div>
                                         <div class="form-group">
                                    <select id="invoiceTypeSelector" class="form-control select2-show-search" style="width: 100%" name="type">
    
                                        {{-- <option selected disabled>-----Select-----</option> --}}
                                        <option value="property" selected>Rent Collection Bills</option>
                                        <option value="owner_expense">Property Bills</option>
                                            <option value="agency">Agency Bills</option>
    
                                    </select>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="tenantSelector" class="col-md-6">
                                <label>Select Property <span class="text-danger">*</span></label>
                                
                                <div>
                                     <div class="form-group">
                                <select class="form-control select2-show-search" style="width: 100%" name="apartment_id">

                                    <option selected disabled>-----Select-----</option>
                                    @foreach ($apt_grouped as $apt)
                                        <option value="{{ $apt['id']}}">{{ $apt['apartment_name']}} - Balance: {{ $apt['amount']}} </option>

                                        @endforeach

                                </select>
                                </div>
                                </div>
                               
                            </div>
                             <div id="invoiceSelector" class="col-md-12">
                                <label>Select Bill <span class="text-danger">*</span></label>
                                
                                <div>
                                     <div class="form-group">
                                <select class="form-control select2-show-search" style="width: 100%" name="landlord_id">

                                    <option selected disabled>-----Select-----</option>
                                  @forelse ($payowner as $pay)
                                  @if($pay->balance > 0)
                                  
                                <option value="{{$pay->id}}">Type: Agency Bill (Bill #{{$pay->id}} Type: {{$pay->type}}) - To Pay: {{$pay->balance}}</option>
                               @endif
                                        @empty

                                        @endforelse

                                </select>
                                </div>
                                </div>
                                
                                  <label>Paying Bill For?</label>
                                    <div>
                                       <div class="form-group">
                                    <select id="invoiceTypeSelector" class="form-control select2-show-search" style="width: 100%" name="agency_bill_for">
    
                                        <option >-----Select-----</option>
                                       <option value="Agency Bill-Rent" >Rent</option>
                                       <option value="Agency Bill-Wages" >Wages</option>
                                       <option value="Agency Bill-Stationary">Stationary</option>
                                       <option value="Agency Bill-Electricity">Electricity Bill</option>
                                       <option value="Agency Bill-Water">Water Bill</option>
                                       <option value="Agency Bill-Office Refreshments">Office Refreshments</option>
                                       <option value="Agency Bill-Travels">Travels</option>
                                       <option value="Agency Bill-Branding and Marketing">Branding and Marketing</option>
                                       <option value="Agency Bill-Professional Fees">Professional Fees</option>
                                       <option value="Agency Bill-Bank Charges">Bank Charges</option>
                                       <option value="Agency Bill-Web Hosting">Web Hosting</option>
                                       <option value="Agency Bill-Internet Charges">Internet Charges</option>
                                       <option value="Agency Bill-Others">Others</option>
    
                                    </select>
                                    </div>
                                        
                                    </div>
                                     <label>Service Provider</label>
                                    <div>
                                        <div class="form-group">
                                            
                                                <input class="form-control " type="text" id="example-text-input" name="agency_service_provider"
                                        value="">
                                            
                                        </div>
                                        
                                    </div>
                            
                               
                            </div>
                            <div id="invoiceSelector2" class="col-md-12">
                                <label>Select Bill <span class="text-danger">*</span></label>
                                
                                <div>
                                     <div class="form-group">
                                <select class="form-control select2-show-search" style="width: 100%" name="landlord_id">

                                    <option selected disabled>-----Select-----</option>
                                
                                    @forelse ($payowners as $payy)
                                    @if($payy->balance > 0)
                               
                               
                                <option value="{{$payy->id}}">Type: Service Request (Bill #{{$payy->description}}) - To Pay: {{$payy->balance}}</option>
                                @endif
                                
                                        @empty

                                        @endforelse
                                        
                                         @foreach ($apt_grouped as $apt)
                                         @if($apt['electricity'] > 0 && $apt['amount'] > 0)
                                        <option value="{{ $apt['id']}}">Electicity Bills: {{ $apt['apartment_name']}} - Amount: {{ $apt['electricity']}} </option>
                                         @endif
                                        @if($apt['water'] > 0 && $apt['amount'] > 0)
                                        <option value="{{ $apt['id']}}">Water Bills: {{ $apt['apartment_name']}} - Amount: {{ $apt['water']}} </option>
                                        @endif
                                        @if($apt['litter'] > 0 && $apt['amount'] > 0)
                                        <option value="{{ $apt['id']}}">Litter Bills: {{ $apt['apartment_name']}} - Amount: {{ $apt['litter']}} </option>
                                        @endif
                                        @if($apt['security'] > 0 && $apt['amount'] > 0)
                                        <option value="{{ $apt['id']}}">Security Bills{{ $apt['apartment_name']}} - Amount: {{ $apt['security']}} </option>
                                        @endif
                                        @if($apt['compound'] > 0 && $apt['amount'] > 0)
                                        <option value="{{ $apt['id']}}">Compound Cleaning Bills{{ $apt['apartment_name']}} - Amount: {{ $apt['compound']}} </option>
                                        @endif

                                        @endforeach

                                </select>
                                </div>
                                </div>
                       
                                <label>Paying Bill For?</label>
                                    <div>
                                       <div class="form-group">
                                    <select id="invoiceTypeSelector" class="form-control select2-show-search" style="width: 100%" name="bill_for">
    
                                        <option >-----Select-----</option>
                                        <option value="Electricity Bill">Electricity</option>
                                        <option value="Water Bill">Water</option>
                                            <option value="Litter Collection Bill">Litter Collection</option>
                                            <option value="Compound Cleaning & Maintenance Bill">Compound Cleaning & Maintenance</option>
                                            <option value="Security Bill">Security</option>
                                            <option value="Service Request">Service Request</option>
    
                                    </select>
                                    </div>
                                        
                                    </div>
                                     <label>Service Provider</label>
                                    <div>
                                        <div class="form-group">
                                            
                                                <input class="form-control " type="text" id="example-text-input" name="service_provider"
                                        value="">
                                            
                                        </div>
                                        
                                    </div>
                            </div>
                           
                           
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="example-text-input">Payment Method <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search"  name="payment_type">

                                    <option selected disabled>-----Select-----</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Bank</option>
                                    <option value="Mpesa">Mpesa</option>
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label>Transaction Code<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-group">
                                            
                                                <input class="form-control " type="text" id="example-text-input" name="reference"
                                        value="">
                                            
                                        </div>
                                        
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <label>Amount<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-group">
                                            
                                                <input class="form-control " type="number" id="example-text-input" name="amount"
                                        value="">
                                            
                                        </div>
                                        
                                    </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <label>Date </label>
                                
                                    <div class="form-group">
                                        <div class="cal-icon">
                                            <input class="form-control " type="date" name="payment_date"
                                                value="">
                                        </div>
                                    </div>
    
                                </div>
                           
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Pay Bill</button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
    @else
       <form action="{{ route('bill.payManagerNow')}}" method="post" class="card">
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
                            <div class="col-md-12">
                                    <label>Bills Type <span class="text-danger">*</span></label>
                                    
                                    <div>
                                         <div class="form-group">
                                    <select id="invoiceTypeSelector" class="form-control select2-show-search" style="width: 100%" name="type">
    
                                        {{-- <option selected disabled>-----Select-----</option> --}}
                                          <option value="property" selected>Rent Collection Bills</option>
                                        <option value="owner_expense">Property Bills</option>
                                            <option value="agency">Agency Bills</option>
    
                                    </select>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="tenantSelector" class="col-md-6">
                                <label>Select Property <span class="text-danger">*</span></label>
                                
                                <div>
                                     <div class="form-group">
                                <select class="form-control select2-show-search" style="width: 100%" name="apartment_id">

                                    <option selected disabled>-----Select-----</option>
                                    @foreach ($apt_grouped as $apt)
                                        <option value="{{ $apt['id']}}">{{ $apt['apartment_name']}} - {{ $apt['landlord_name']}}</option>

                                        @endforeach

                                </select>
                                </div>
                                </div>
                               
                            </div>
                            <div id="invoiceSelector" class="col-md-6">
                                <label>Select Bill <span class="text-danger">*</span></label>
                                
                                <div>
                                     <div class="form-group">
                                <select class="form-control select2-show-search" style="width: 100%" name="landlord_id">

                                    <option selected disabled>-----Select-----</option>
                                  @forelse ($payowners as $pay)
                                  
                                <option value="{{$pay->id}}">Type: Agency Bill (Bill #{{$pay->id}}) - To Pay: {{$pay->balance}}</option>
                               
                                        @empty

                                        @endforelse

                                </select>
                                </div>
                                </div>
                               
                            </div>
                            <div id="invoiceSelector2" class="col-md-6">
                                <label>Select Bill <span class="text-danger">*</span></label>
                                
                                <div>
                                     <div class="form-group">
                                <select class="form-control select2-show-search" style="width: 100%" name="landlord_id">

                                    <option selected disabled>-----Select-----</option>
                                    @forelse ($payowner as $payy)
                                    
                               
                               
                                <option value="{{$payy->id}}">Type: {{$payy->type}} (Bill #{{$payy->id}}) - To Pay: {{$payy->balance}}</option>
                                
                                        @empty

                                        @endforelse

                                </select>
                                </div>
                                </div>
                               
                            </div>
                           
                            <div class="col-md-6">
                                <label>Transaction Code<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-group">
                                            
                                                <input class="form-control " type="text" id="example-text-input" name="reference"
                                        value="">
                                            
                                        </div>
                                        
                                    </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="example-text-input">Payment Method <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search"  name="payment_type">

                                    <option selected disabled>-----Select-----</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Bank</option>
                                    <option value="Mpesa">Mpesa</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Amount<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-group">
                                            
                                                <input class="form-control " type="number" id="example-text-input" name="amount"
                                        value="">
                                            
                                        </div>
                                        
                                    </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Date </label>
                                
                                    <div class="form-group">
                                        <div class="cal-icon">
                                            <input class="form-control " type="date" name="payment_date"
                                                value="">
                                        </div>
                                    </div>
    
                                </div>
                           
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Pay Bill</button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
    @endif
								

								
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

    $(document).ready(function () {
        var x = document.getElementById("invoiceTypeSelector").value;
        $("#tenantSelector").hide();
        $("#invoiceSelector").hide();
   $("#invoiceSelector2").hide();
        if ( x == 'property')
        {
            $("#tenantSelector").show();
        $("#invoiceSelector").hide();
         $("#invoiceSelector2").hide();

        }else if ( x == 'agency'){
            $("#tenantSelector").hide();
        $("#invoiceSelector").show();
         $("#invoiceSelector2").hide();
  
        }
        else if ( x == 'owner_expense'){
            $("#tenantSelector").hide();
        $("#invoiceSelector").show();
         $("#invoiceSelector2").hide();
  
        }
       
    });
    
    $('#invoiceTypeSelector').change(function(){
        var x = document.getElementById("invoiceTypeSelector").value;
        $("#tenantSelector").hide();
        $("#invoiceSelector").hide();
         $("#invoiceSelector2").hide();
        
     
        if ( x == 'property')
        {
            $("#tenantSelector").show();
        $("#invoiceSelector").hide();
         $("#invoiceSelector2").hide();
   
        }else if ( x == 'agency'){
            $("#tenantSelector").hide();
        $("#invoiceSelector").show();
         $("#invoiceSelector2").hide();

        }else if ( x == 'owner_expense'){
            $("#tenantSelector").hide();
        $("#invoiceSelector2").show();
         $("#invoiceSelector").hide();

        }
    });
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
@endsection