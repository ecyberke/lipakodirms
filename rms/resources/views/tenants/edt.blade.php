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
									<li class="breadcrumb-item"><a href="{{ route('tenant.all')}}">Tenants</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit Tenant's Details</li></li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
<div class="content container-fluid">

    <!-- Page Title -->
    {{-- <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">New Tenant</h4>
        </div>
    </div> --}}
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    {{-- <h4 class="mt-0 header-title">Update Tenant Details </h4> --}}
                    <p class="text-muted m-b-10 font-14">
                    </p>
                    @include('includes.messages')
                    <div class="p-20 pt-2">
                        <form action="{{ route('tenant.update', $tenant->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                         
                               <div class="row">
                                <div class="col-md-12">
                                    <label>Tenancy<span class="text-danger">*</span></label>
                                    
                                    <select  class="form-control select2-show-search" id="type" style="width: 100%" name="type_select">
                                     @if($tenant->type_select == null)
                                        <option selected disabled>-----Select-----</option>
                                     @else
                                      <option value="{{$tenant->type_select}}">{{$tenant->type_select}}</option>
                                     @endif
                                    <option value="Company">Company</option> 
                                    <option value="Tenant">Individual</option>
                                    
                               
                                    </select>
                                   
                                </div>
                                </div><br>
                            <div class="row" id="tenant">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Full Names <span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="full_name"
                                        value="{{  $tenant->full_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Phone Number<span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="phone"
                                        value="{{  $tenant->phone }}" >
                                    </div>
                                </div>
                            </div>
                            
                           
                        </div>
                   
                            <div class="row" id="company">
                                 <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Company Names <span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="company_name"
                                        value="{{  $tenant->full_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Contact Person Full Names <span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="contact_person"
                                        value="{{  $tenant->person }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Phone Number<span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="company_phone"
                                        value="{{  $tenant->phone }}" >
                                    </div>
                                </div>
                            </div>
                            
                           
                        </div>
                   
                        <!-- end row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>National ID Number / Passport </label>
                                    <div>
                                        <input type="text" class="form-control" name="id_number" value="{{  $tenant->id_number}}"  id="passport">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <div>
                                        <input type="text" class="form-control" name="email"
                                        value="{{  $tenant->email }}">
                                    </div>
                                </div>
                            </div>
                            

                            
                             <div class="col-sm-4">                                
                                <div class="form-group">
                                    <label>Occupation Status:</label>
                                    <div>
                                        <select class="form-control select2-show-search" name="occupation">
                                            <option>{{  $tenant->occupation }}</option>
                                            <option>Employed</option>
                                            <option>Self-Employed</option>
                                            <option>Student</option>
                                            <option>Unemployed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-sm-12">
                                     <div class="form-group">
                                            <label>Tenant Contract</label>
                                            <div>
                                                <input type="file" name="filenames" class="myfrm form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-12">
                                <p class="text-muted m-b-30 font-14">NEXT OF KIN
                                </p>
                            </div>

                        </div>
                        <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Names</label>
                                <div>
                                    <input type="text" class="form-control" name="emergency_person" value="{{ $tenant->emergency_person }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Phone Number:</label>
                                <div>
                                    <input type="tel" class="form-control" name="emergency_number" value="{{ $tenant->emergency_number }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>ID/Passport Number:</label>
                                <div>
                                    <input type="text" class="form-control" name="kin_id" value="{{ $tenant->kin_id }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Relationship:</label>
                                <div>
                                    <input type="text" class="form-control" name="relationship" value="{{ $tenant->relationship }}">
                                </div>
                            </div>
                        </div>
                        </div>
                            

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Update Tenant
                                            </button>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                   


                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- /Content End -->

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
        var y = document.getElementById("type").value;
        $("#tenant").hide();
        $("#company").hide();
        if ( y == 'Company')
        {
            $("#company").show();
        }
        else if ( y == 'Tenant')  {
            $("#tenant").show();
        }
    });

     $('#type').change(function(){
        var x = document.getElementById("type").value;
        $("#tenant").hide();
        $("#company").hide();
        if ( x == 'Tenant'){
            $("#tenant").show();
        }else if(x == 'Company'){
            $("#company").show();
        }
    });
 


  

   

    
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
@endsection
