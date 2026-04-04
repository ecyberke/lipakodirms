<!-- START OF REMITTANCE FORM -->
@extends('layouts.master') 
@section('css')
<!-- Keep all current CSS intact -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multi/multi.min.css')}}">
@endsection

@section('page-header')
<div class="page-header">
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home')}}" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Remittance</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form action="{{route('bill.store')}}" method="post" class="card" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @include('includes.messages')
                
                <div class="row">
                    <div class="col-md-12">
                         <!-- Hidden field to set bill type as property -->
                <input type="hidden" name="bill_type" value="rent">
                
                <!-- Hidden field to set bill category as service (since it's the only option) -->
                        <label>Select Property <span class="text-danger">*</span></label>
                        <select class="form-control select2-show-search" name="apartment_id" id="apartmentSelect" required>
                            <option disabled selected>-----Select Property-----</option>
                            @foreach($apartments as $apartment => $id)
                                <option value="{{$id}}">{{$apartment}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-12">
                        <label>Remittance Category <span class="text-danger">*</span></label>
                        <select id="remittanceCategory" class="form-control select2-show-search" name="bill_category" required>
                            <option value="" disabled selected>--select category--</option>
                              @foreach($bill_category as $cat)
                                <option value="{{ $cat->category_name }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        <small><a href="{{ route('bills-categories.create') }}">Add new bill category</a></small>
                    </div>
                </div><br>

                 <div class="row">
                    <div class="col-md-12">
                        <label>Remittance Details <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="bill_description" required>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-6">
                        <label>Attach Document</label>
                        <input type="file" name="proof" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="bill_amount" required>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-6">
                        <label>Transaction Code  <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="transaction_code">
                    </div>
                    <div class="col-md-6">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="bill_date" required>
                    </div>
                </div><br>
                 <input type="hidden" name="approval" value="{{ Auth::user()->is_admin == 2 ? 1 : 0 }}">


                <div class="row mb-4">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Create Remittance</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script>
$(document).ready(function () {
    
    // Auto-populate description with category and property
    $('#remittanceCategory').change(function() {
        const category = $(this).val();
        const property = $('#apartmentSelect option:selected').text();
        
        if (category && property && property !== '-----Select Property-----') {
            const currentDesc = $('textarea[name="remittance_description"]').val();
            if (!currentDesc) {
                $('textarea[name="remittance_description"]').val(category + ' remittance for ' + property);
            }
        }
    });
    
    // Ensure property is selected before category
    $('#remittanceCategory').focus(function() {
        const propertyId = $('#apartmentSelect').val();
        if (!propertyId || propertyId === '-----Select Property-----') {
            alert('Please select a property first');
            $(this).blur();
            $('#apartmentSelect').focus();
        }
    });
    
});
</script>
@endsection