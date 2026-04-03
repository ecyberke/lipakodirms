@extends('layouts.home')

@section('content')

<div class="content container-fluid">

    <div class="row">
        <div class="col-md-12">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    {{-- <div class="col-sm-12">
                        <h3 class="page-title">Edit House Details</h3>
                    </div> --}}
                </div>
            </div>
            <!-- /Page Header -->

            @include('includes.messages')
            <form action="{{ route('expenses.update',$agency_expenses->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                    <label>Transaction Code <span class="text-danger">*</span></label>
                                    <input type="text" name="transaction_code" class="form-control" value="{{$agency_expenses->transaction_code}}" >
                                    </div>
                                    
                                        <div class="col-sm-4">
                                            <label>Amount Paid (Ksh.)  <span class="text-danger">*</span></label>
                                            
                                                <input type="text" name="amount" class="form-control" value="{{$agency_expenses->amount}}" >
                                           
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Payment Status<span class="text-danger">*</span></label>
                                                <select class="select"  name="status">

                                                    <option selected>
                                                    @if($agency_expenses->status == 0)
                                                        <p style="color: #FF0000;">Unpaid</p>
                                                    @elseif($agency_expenses->status == 1)
                                                        <p style="color: #00bfff;">Paid</p>
                                                    {{-- @elseif($agency_expenses->status == 2 )
                                                        <p style="color: #66CD00;">Partial</p> --}}
                                                    @endif
                                                    </option>
                                                    <option value="0">unpaid</option>
                                                    {{-- <option value="2">Partial</option> --}}
                                                    <option value="1">Paid</option>
                
                                                </select>
                                                </div>
                                        
                                </div><br>
                            
                                
                    
                                {{-- <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label"> <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control text-uppercase" name="house_no" value="">
                                </div>
                                </div> --}}
                                
                                
                              
                                
                                {{-- <div class="form-group">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">Description</label>
                                   
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="house_description">
                                </div>
                                </div> --}}

                                <div class="row mb-4">
                            <div class="col-sm-8">
                                <button class="btn btn-success" type="submit">  Update Bill
                                </button>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                            
        </div>

            </form>

            

               
        </div>
    </div>




</div>

@endsection