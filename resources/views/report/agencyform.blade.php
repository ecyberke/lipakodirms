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
									<li class="breadcrumb-item active" aria-current="page">Agency Statement</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection

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
    <form action="{{route('agency_statement')}}" method="get">
        @csrf
        
        
        <div class="row">
           

            <div class="col-10">
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
                        {{-- <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Select Tenant <span class="text-danger">*</span></label>
                          
                            <div class="col-sm-8">
                                <select class="form-control select2-show-search" style="width: 100%"  name="tenant_id">

                                    <option selected disabled>-----Select-----</option>
                                    @forelse ($tenants as $tenant=>$key)
                                        <option value="{{$key}}">{{ $tenant}}</option>
                                        @empty

                                        @endforelse

                                </select>
                            </div>
                        </div> --}}
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

                        </div>
                        </div><br>
                       
                      
                            
                       
                            
                        
                        
                        
                  

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Get Statement</button></button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
    
    </div>
    @if($hasReport)
    <div class="card" style="padding-top:25px; padding-bottom:25px; padding-left:25px; padding-right:25px;">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>Agency Statement</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Admin Name:</strong> <span>{{$other_info['name'] }}</span></p>
                            <p><strong>Email:</strong> <span>{{$other_info['email'] }}</span></p>
                            <p><strong>Date of Statement:</strong> <span>{{$other_info['date'] }}</span></p>
                            <p><strong>Statement Period:</strong> <span>{{$other_info['from_to'] }}</span></p>
                        </div> <!-- end col -->
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                            <div class="mt-3 float-right">
                                <img src="https://lesaagencies.co.ke/rms/assets/img/lesa.png" alt="" height="100">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Detailed Statement</h4>
                        </div>
                    </div>
                    <div class="row table-responsive   ">
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                            <thead>
                              <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Details</th>
                                <th>Income</th>
                                <th>Expense</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($entries as $entry)
                              <tr>
                                <th>{{$entry['date']}}</th>
                                <td>{{$entry['reference']}}</td>
                                <td>{{$entry['description']}}</td>
                                
                                @if($entry['income'] === '-')
                                <td>
                                    {{$entry['income']}}
                                </td>
                                @else 
                                <td >
                                    {{$entry['income']}}
                                </td>
                                @endif
                                @if($entry['expense'] === '-')
                                <td>
                                    {{$entry['expense']}}
                                </td>
                                @else 
                                <td >
                                    {{$entry['expense']}}
                                </td>
                                @endif
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Summary</h4>
                        </div>
                    </div>
                   <div class="row table-responsive   ">
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                            <thead>
                              <tr>
                                <td>Details</td>
                                <td >Amount</td>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td >Rent Collection Commission</td>
                                    <td >{{$rent_collection_commission}}</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td >Placement Fees Income</td>
                                    <td >{{$placement_fee_income}}</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td >Other Income</td>
                                    <td >{{$other_incomes_totals}}</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td >Total</td>
                                    <td >{{$income_total}}</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td >Expenses</td>
                                    <td >-{{$total_expense}}</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td>Balance</td>
                                    <td>{{$balance}}</td>
                                </tr>
                            </tbody>
                          </table>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                                <a  href="{{\Request::fullUrl()}}&download=yes" target="_blank" class="m-2 btn btn-success waves-effect waves-light">Download Statement</a>
                            </div>
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
@endif

    <!-- /Content End -->

</div>
@endsection

@push('footer_scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
     $(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
@endpush