@extends('layouts.home')

@push('header_scripts')
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    {{-- <li class="breadcrumb-item active">Pay Owners</li> --}}
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">

                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                    <h3 class="user-name m-t-0">{{$payowners->apartment->landlord->full_name}}</h3>
                                        
                                        

                                    </div>
                                </div>
                                <div class="col-md-7">


                                    
                                        
                                       
                                        <h3 class="staff-id"> Phone Number :{{$payowners->apartment->landlord->id}} </h3>
                                        {{-- <li>
                                            <span class="title">Paying To:</span></li> --}}
                                          
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-5 ">
            <div class="card profile-box flex-fill">
                <div class="card-body">
                    <h3 class="card-title">Payable Bills</h3>

                    <hr class="my-4">

                    <div class="form-group row">
                        <label class="col-form-label col-md-4 ">PAY</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control"
                        value="Ksh {{$payowners->total_owned}}" readonly >
                        </div>
                    </div>
                    



                   


                </div>
            </div>
        </div>


        <div class="col-7 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Pay Here</h3>

                    @include('includes.messages')

                <form action="{{route('payowners.payment')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label text-right">Agency To Pay</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" readonly id="total_bills"
                            value="{{$payowners->balance}}"
                                    >
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label text-right">Agency Commission</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" readonly id="total_bills"
                            value="{{$payowners->commission}}"
                                    >
                            </div>
                            
                        </div>

                        <input type="hidden" name="landlord_id" value="{{$payowners->landlord_id}}">
                        {{-- <input type="hidden" name="invoice_id" value="{{ >id}}"> --}} 
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label text-right">Payment Method</label>
                            <div class="col-lg-6">
                                <select class="form-control" name="transaction_type">
                                    <option  selected disabled> -- Select -- </option>
                                    <option> Cash</option>
                                    <option> Bank</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label text-right">Transaction Code</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="paid-in" name="transaction_code">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label text-right">Amount Paid</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="paid-in" name="paid_in">
                            </div>
                        </div>
                      



                        
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-success ">Pay Now</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Resignation Modal -->
<div id="show_breakdown" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rent Calculations BreakDown</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Total Monthly Bills </label>
                        <input class="form-control" type="text" readonly
                                           >
                    </div>
                   
                    <div class="form-group">
                        <label>Already Paid In </label>

                        <input type="text" class="form-control " readonly
                            
                            >

                    </div>
                    <div class="form-group">
                        <label>Balance To Pay </label>

                        <input type="text" class="form-control " readonly
                            
                            >

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Resignation Modal -->


@endsection

@push('footer_scripts')
<script>


</script>
@endpush