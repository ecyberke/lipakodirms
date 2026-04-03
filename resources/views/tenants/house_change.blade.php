@extends('layouts.home')

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
                        <form action="{{ route('house.update', $house_tenant->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Full Names <span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" 
                                        value="{{  $house_tenant->tenant->full_name }}" readonly>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-4">                                
                                <div class="form-group">
                                    <label>House:</label>
                                    <div>
                                       <select class="js-example-basic-single select" style="width: 100%"  name="house_id">

                                        <option selected>{{ $house_tenant->house->house_no}}</option>

                                        @forelse ($house as $house)
                                        <option value="{{$house_id}}">{{ $house_tenant->house->house_no}}</option>
                                        @empty

                                        @endforelse

                                    </select>
                                    </div>
                                </div>
                            </div>
                            
                            
                           
                        </div>
                        <!-- end row -->
                       
                       
                       
                            

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                               Change House
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

@push('footer_scripts')      

@endpush