@extends('layouts.home')

@push('header_scripts')
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Agency Income - Monthly Basis</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Income</a></li>
                    <li class="breadcrumb-item active">Agency</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Title -->

    <!-- Content Starts -->

    <!-- Search Filter -->
    <div class="row filter-row mb-3">
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus select-focus">
                <select class="select floating" name="month" id="month">
                    <option>-</option>
                    <option>Jan</option>
                    <option>Feb</option>
                    <option>Mar</option>
                    <option>Apr</option>
                    <option>May</option>
                    <option>Jun</option>
                    <option>Jul</option>
                    <option>Aug</option>
                    <option>Sep</option>
                    <option>Oct</option>
                    <option>Nov</option>
                    <option>Dec</option>
                </select>
                <label class="focus-label">Select Month</label>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus select-focus">
                 <select class="select floating" name="year" id="year">

                    @for ($i = 2019; $i < 2026 ; $i++) <option>{{ $i}}</option>
                        @endfor
                </select>
                <label class="focus-label">Select Year</label>
               
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            @csrf
            <button class="btn btn-success btn-block" id="btn-search"> Search </button>
        </div>
    </div>
    <!-- /Search Filter -->


    {{-- stats row --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card-group m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Agency Total Rent Collection</span>
                            </div>
                        </div>
                        <h3 class="mb-3" id="total_rent"></h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Total Placement Fee Collection</span>
                            </div>
                        </div>
                        <h3 class="mb-3" id="placement-fee"></h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Agency Revenue on Placement</span>
                            </div>
                        </div>
                        <h3 class="mb-3" id="company-placement"></h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Agency Revenue on Viewing Fees</span>
                            </div>
                        </div>
                        <h3 class="mb-3" id="company-placement"></h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Agency Revenue on Rent</span>
                            </div>
                        </div>
                        <h3 class="mb-3" id="compny-mgnt-fee"></h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Stats row End -->

    <!-- /Details row -->
    <div class="row">

        <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-header">
                <h4 class="card-title mb-0">Total Revenue per Month</h4>
                </div>

                <div class="card-body p-3">
                    <div class="table-responsive table-rent">

                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-md-6 d-flex">
            <div class="card card-table flex-fill">

                <div class="card-header">
                    <h4 class="card-title mb-0">Placement Fee Collections</h4>
                </div>
                <div class="card-body p-3">

                    <div class="table-responsive table-placement">

                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /Details row End -->
    <!-- /Content End -->

</div>
@endsection

@push('footer_scripts')
<script>

    $('#btn-search').on('click', function () {

        var month = $('#month').val();
        var year = $('#year').val();
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{!! route('income.all') !!}",
            method: 'POST',
            data: { 'month': month, 'year': year, '_token': token },
            success: function (data) {

                $('#placement-fee').text('Ksh ' + data.total_placement);
                $('#company-placement').text('Ksh ' + data.company_placement);
                $('#total_rent').text('Ksh ' + data.total_rent);


                $('.table-rent').html('');
                $('.table-rent').html(data.rent_view);
                $('.table-placement').html('');
                $('.table-placement').html(data.placement_view);

                $('#compny-mgnt-fee').text('Ksh 0');
                $('#compny-mgnt-fee').text($('#company-fee').val());

            },
            error: function () {
                alert("error!!!!");
            }
        });






    });

</script>
@endpush