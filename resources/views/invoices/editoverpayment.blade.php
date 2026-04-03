@extends('layouts.home')

@section('content')
<div class="content container-fluid">

    <div class="row ">
        <div class="col-sm-6">
            <h4 class="page-title">Update Overpayment </h4>
        </div>
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
                        <form action="{{route('overpayment.update',$overpayment->id)}}" method="post">
                            @csrf
                            @method('PUT')

                             <div class="form-group row">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Tenant With Overpayment</label>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" id="example-text-input"  readonly
                                        value="{{ $overpayment->tenant->full_name }}">
                                </div>
                            </div>  

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Amount Overpaid:</label>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" id="example-text-input" name="amount"
                                        value="{{ $overpayment->amount }}">
                                </div>
                            </div>                                                                                                 
                          
                            <div class="row">
                                <div class="col-sm-7 offset-sm-3">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mr-3">Update
                                        Overpayment</button>
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

