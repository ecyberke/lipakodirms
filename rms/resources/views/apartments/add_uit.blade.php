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
									<li class="breadcrumb-item active" aria-current="page">Add Houses</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
			  <!-- Content Starts -->

    <div class="row">
        
        <div class="col-12">
            <div class="">
            @include('includes.messages')
            <form action="{{ route('apartment.store_unit')}}" method="post" enctype='multipart/form-data' class="card">
                @csrf
               
                <div style="padding-top:25px; padding-bottom:25px; padding-left:25px; padding-right:25px;">
                    <form action="{{route('apartment.store')}}" method="post"  enctype="multipart/form-data" >
                        @csrf
                        @if (isset($var))
                                    
                        <div class="col-md-5">
                            <div class="form-group form-focus">
                                <input type="text" class="form-control floating" readonly
                                    value="{{ $apartment_name->name }}">
                                <label class="focus-label">Property Name</label>
                            </div>

                            <input type="hidden" name="apartment_id" value="{{$var}}"
                                id="apartment-id-hidden">
                        </div>
                        <div class="col-3">
                            <a href="{{ route('apartment.add_unit')}}" class="btn btn-secondary btn-block">
                                Change
                            </a>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-sm-6">
                            <label >Property<span class="text-danger"> *</span></label>
                            {{-- <label for="id_label_single"  class="text-muted"> <span class="text-danger">*</span></label> --}}
                            {{-- <div   class="form-group form-focus select-focus"> --}}
                                
                                <select class="form-control select2-show-search" style="width: 100%" name="apartment_id" id="apartment_id">
                                    <option >--choose--</option>
                                    @forelse ($apartments as $apartment=>$key)
                                    <option value="{{$key}}">{{ $apartment }}</option>
                                    @empty
                                    @endforelse

                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label >House Type<span class="text-danger"> *</span></label>
                                {{-- <label for="id_label_single"  class="text-muted">House Type <span class="text-danger">*</span></label> --}}
                                
                                <select class="form-control select2-show-search" style="width: 100%" name="house_type">
                                    <option>---choose---</option>
                                        <option>Standalone</option>
                                        <option>Flat</option>
                                        <option>Bungalow</option>
                                        <option>Plot</option>
                                        <option>Office</option>
                                        <option>Highrise Building</option>
                                        <option>Massionate</option>
                                        <option>Apartment</option>
                                        <option>Shop</option>
                                        <option>Others</option>
                                </select>
                       
                            
                            </div>
                              
                        </div>
                        @endif
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                            <label >House</label>
                             <input type="text" class="form-control text-uppercase" name="house_no" value="1">
                                <span class="form-text text-muted text-info">Defaults to " 1 " if the house is standalone.</span>        
                        </div>
                        <div class="col-sm-4">
                        <label >Monthly Rent<span class="text-danger"> *</span></label>
                 
                        
                            <input type="text" class="form-control" name="rent_amount">
               
                    
                    </div>
                    <div class="col-sm-4">
                        <label >Payment Period<span class="text-danger"> *</span></label>
                 
                        
                             <select class="form-control select2-show-search" style="width: 100%" name="rent_period">
                                    <option>---choose---</option>
                                        <option value="1" >1 Month</option>
                                        <option value="2" >2 Months</option>
                                        <option value="3" >3 Months</option>
                                        <option value="4" >4 Months</option>
                                        <option value="5" >5 Months</option>
                                        <option value="6" >6 Months</option>
                                        <option value="7" >7 Months</option>
                                        <option value="8" >8 Months</option>
                                        <option value="9" >9 Months</option>
                                        <option value="10" >10 Months</option>
                                        <option value="11" >11 Months</option>
                                        <option value="12" >12 Months</option>
                                      
                                </select>
               
                    
                    </div>
                    </div>
                    <hr>
                    <h5>Monthly Bills</h5>
                    <hr>
                    <div class="row">
                            <div class="col-sm-3">
                            <label >Electricity</label>
                            {{-- <label for="id_label_single"  class="text-muted">House Type </label> --}}
                           
                                <input type="text" class="form-control" name="electricity_bill" >
                                    
                        </div>
                        <div class="col-sm-3">
                        <label >Water</label>
                       
                        
                            <input type="text" class="form-control" name="water_bill">
               
                    
                    </div>
                    <div class="col-sm-3">
                        <label >Litter Collection</label>
                      
                        
                            <input type="text" class="form-control" name="litter_bill">
               
                    
                    </div>
                    <div class="col-sm-3">
                        <label >Compound Maintenance</label>
                 
                        
                            <input type="text" class="form-control" name="compound_bill">
               
                    
                    </div>
                    
                    </div><br>
                    <div class="row">
                            
                            
                    <div class="col-sm-6">
                        <label >Security</label>
                      
                        
                            <input type="text" class="form-control" name="security">
               
                    
                    </div>
                    <div class="col-sm-6">
                        <label >Others</label>
                 
                        
                            <input type="text" class="form-control" name="others">
               
                    
                    </div>
                    </div><hr>
                        

                        

                        <div class="row">
                            <div class="col-sm-12">
                            <label >House
                                Description <span class="text-muted test-small"></span></label>
                            
                                <input type="text" class="form-control" name="house_description">
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                            <label >Add House Images<span class="text-muted test-small"></span></label>
                            
                            <input type="file" multiple name="filenames[]" class="myfrm form-control">
                        </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8 ">
                                <button type="submit" class="btn btn-success mr-3">Save House
                                </button>

                            </div>

                        </div>
                    </form>
                </div>
                
       
           
        </div>
        </div>
 
    </div>


</div>




<!-- /Content End -->
			
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
    $(function () { 
        var oTable = $('#table-houses').DataTable(
            {
                destroy: true,
                "pageLength": 10,
                "bLengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    method: 'GET',
                    url: '{!! route('api.houses.apartment') !!}',
                    data: function (d) {
                        d.token = $("input[name='_token']").val();
                        d.id = $("#apartment_id option:selected").val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'house_no', name: 'house_no' },
                    { data: 'house_type', name: 'house_type' },
                    { data: 'rent', name: 'rent' },

                ]
            }
           );

        //change datatable on selected apartment
        $('#apartment_id').on('change', function (event) {            
            oTable.draw();
            event.preventDefault();
        });


        $('#btn-check').on('click', function (event2) {           
            oTable.draw();
            event.preventDefault();
        })







    });
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
@endsection