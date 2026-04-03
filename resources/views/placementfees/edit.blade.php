@extends('layouts.home')

@section('content')
<div class="content container-fluid">

    <div class="row ">
        <div class="col-sm-6">
            <h4 class="page-title">Update Placement Fee </h4>
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
                        <form action="{{route('placementfee.update',$placement->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Amount Paid</label>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" id="example-text-input" name="amount"
                                        value="{{ $placement->amount }}">
                                </div>
                            </div>                                                                                                 
                          
                            <div class="row">
                                <div class="col-sm-7 offset-sm-3">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mr-3">Update
                                        Placement</button>
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

