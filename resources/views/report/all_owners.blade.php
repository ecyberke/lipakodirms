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
									<li class="breadcrumb-item"><a href="#">Reports</a></li>
									<li class="breadcrumb-item active" aria-current="page">All Owners in a Period</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection

@section('content')
<div class="content container-fluid">

    <!-- Page Title -->
    <div class="row">
       
    </div>
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="card">
    <form action="{{route('report.houses_reports_generate')}}" method="get">
        @csrf
        
        
        <div class="row">
           

            <div class="col-12">
                <div class="">
                    <div class="card-body">
                       
                        @include('includes.messages')
                       
                        
                        <div class="row">
                            <div class="col-sm-6">
                            <label>From <span
                                    class="text-danger">*</span></label>
                            
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control " type="date" name="from"
                                            value="{{ old('placement_date')}}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                            <label >To<span
                                class="text-danger">*</span></label>
                        
                            <div class="form-group">
                                <div class="cal-icon">
                                    <input class="form-control " type="date" name="to"
                                        value="{{ old('placement_date')}}">
                                </div>
                            </div>
                            <input hidden value="all_property_owners" type="text" name="selected_report"/>

                        </div>
                        </div><br>

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Get Report</button></button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
        @if($has_report)
 <div class="card" style="padding-top:25px; padding-bottom:25px; padding-left:25px; padding-right:25px;">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>{{$report_title}}</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                   <div class="row table-responsive   ">
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                            <thead>
                              <tr>
                                 @foreach($columns as $column)
                                 <th>{{$column['label']}}</th>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $dt)
                              <tr>
                                @foreach($columns as $column)
                                 <td>{{$dt[$column['id']]}}</td>
                                @endforeach
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                                <a  href="{{\Request::fullUrl()}}&download=yes" target="_blank" class="m-2 btn btn-success waves-effect waves-light">Download Report</a>
                            </div>
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>


    <!-- /Content End -->
         @endif
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
@endsection