@extends('layouts.home')

@push('header_scripts')
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


@endpush

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
    <form action="" method="post">
        @csrf
        
        
        <div class="row">
            {{ csrf_field() }}

            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        {{-- <h4 class="mt-0 header-title mb-4">Important Details</h4> --}}

                        {{-- <hr class="mt-2 mb-4"> --}}
                        @include('includes.messages')
                        <div class="row">
                            <div class="col-sm-12">
                            <label>Select Property Owners  <span class="text-danger">*</span></label>
                            <select class="js-example-basic-single select" style="width: 100%"  name="owners_id" multiple>

                                {{-- <option selected disabled>-----Select-----</option> --}}
                                @forelse ($landlords as $landlord=>$key)
                                    <option value="{{$key}}">{{ $landlord}}</option>
                                    @empty

                                    @endforelse

                            </select>
                            </div></div> <br>
                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Message</label>
                                                    <textarea name="message" class="form-control" rows="6"  ></textarea>
                                                        
                                                    </div>
                                        </div><br>
                                                
                                                        
                                
                      
                         
                                

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Send Message</button></button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
    
    </div>


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