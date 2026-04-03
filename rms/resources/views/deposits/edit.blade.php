@extends('layouts.home')

@section('content')
<div class="content container-fluid">

    <div class="row ">
       
    </div>

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="mt-0 header-title"> </h4>
                    <div class="col-6">
                        @include('includes.messages')
                    </div>
                    <div class="p-20">
                        <form action="{{route('deposit.update',$deposit->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Paid On </label>
                                        <div>
                                            <div class="cal-icon">
                                                <input class="form-control " type="text" name="placement_date"
                                                value="{{$deposit->start_month}}" readonly>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Amount Paid</label>
                                        <div>
                                            <input class="form-control" type="text" id="example-text-input" name="amount"
                                        value="{{ $deposit->amount }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                                           
                          
                            <div class="row">
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mr-3">Update
                                        Deposit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
@endsection

