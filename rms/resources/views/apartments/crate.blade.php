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
									<li class="breadcrumb-item active" aria-current="page">Add Property</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
			<!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- <h4 class="mt-0 header-title">Property Information </h4> --}}
                    {{-- <p class="text-muted m-b-30 font-14">After adding new property, proceed to define houses where tenents will live.
                    
                    </p> --}}
                    <div class="col-12">
                        @include('includes.messages')
                    </div>
                    <div class="p-20">
                        <form action="{{route('apartment.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <label >Property
                                        <span class="text-danger"> *</span></label>
                                    
                                        <input class="form-control" type="text" id="example-text-input" name="name"
                                            value="{{old('name')}}">
                                    
                                </div>
                                <div class="col-sm-4">
                                    <label >Town
                                        Located: <span class="text-danger"> *</span></label>
                                    
                                        <input class="form-control" type="text" id="example-text-input" name="town"
                                            placeholder="E.g Matasia" value="{{old('town')}}">
                                 
                                </div>
                                 <div class="col-sm-4">
                                    <label> Reference Number <span class="text-danger"> *</span></label>
                                    
                                        <input class="form-control" type="text" id="example-text-input" name="reference_no"
                                             value="{{old('reference_no')}}">
                                 
                                </div>
                            </div><br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Property
                                            Description <span class="text-muted test-small"></span></label>
                                        
                                            <input class="form-control" type="text" id="example-text-input" name="description"
                                                value="{{old('description')}}">
                                    
                                    </div>
                                    <div class="col-sm-6">
                                        <label >Property
                                            Owner <span class="text-danger"> *</span></label>
                                       
                                            <select class="form-control select2-show-search" style="width: 100%" name="landlord_id">
                                                
        
                                                @forelse ($landlords as $key=>$landlord)
                                                <option value="{{$landlord}}">{{ $key }}</option>
                                                @empty
        
                                                @endforelse
                                            </select>
                                        
                                    </div>

                            </div><br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Number of Houses <span class="text-muted test-small"></span></label>
                                        <div class="input-group ">
                                            <input type="text" class="form-control"  name="houses_qty"
                                            value="" required>
                                        
                                        </div>
                                        
                                
                                </div>
                                <div class="col-sm-6">
                                    <label>Agency Fee
                                        Percentage <span class="text-muted test-small"></span></label>
                                        <div class="input-group ">
                                            <input type="text" class="form-control" aria-label="Management fee"
                                            aria-describedby="basic-addon2" name="management_fee"
                                            value="{{old('management_fee')}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                        </div>
                                        
                                
                                </div>
                                

                        </div><br>
                            

                            <div class="row">
                                <div class="col-sm-8  ">
                                    <button type="submit" class="btn btn-success mr-3">Add Property
                                    </button>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
			
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

@endsection