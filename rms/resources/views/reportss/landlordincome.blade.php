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
                <h3 class="page-title">Property Income - Monthly Basis</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Income</a></li>
                    <li class="breadcrumb-item active">Property</li>
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
                <select class="select floating" name="landlord_id" id="landlord_id">
                    <option>-</option>

                    @forelse ($landlords as $landlord=>$id)
                    <option value="{{$id}}">{{ $landlord}}</option>
                    @empty

                    @endforelse

                </select>
                <label class="focus-label">Select Property Owner</label>
            </div>
        </div>
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

                    @for ($i = 2015; $i < 2100 ; $i++) <option>{{ $i}}</option>
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
                                <span class="d-block">Total Net Rent Collection</span>
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
                                <span class="d-block">Landlord Income on Deposits</span>
                            </div>
                        </div>
                        <h3 class="mb-3" id="income_deposits"></h3>
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
                                <span class="d-block">Landlord Income upon Allocation</span>
                            </div>
                        </div>
                        <h3 class="mb-3" id="income_placements"></h3>
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

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="apartment-rent">

                    </div>


                </div>
            </div>
        </div>

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
        var landlord_id = $('#landlord_id').val();
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{!! route('incomes.landlord') !!}",
            method: 'POST',
            data: { 'month': month, 'landlord_id': landlord_id, 'year': year, '_token': token },
            success: function (data) {

                console.log(data.landlord_deposits)
                $('#income_deposits').text('Ksh 0.00');
                $('#income_deposits').text('Ksh ' + data.landlord_deposits);
                $('#income_placements').text('Ksh 0.00');
                $('#income_placements').text('Ksh ' + data.landlord_placements);
                // $('#company-placement').text('Ksh ' + data.company_placement);

                //$('#total_rent').text('Ksh ' + data.total_rent);


                $('#apartment-rent').html('');
                $('#apartment-rent').html(data.rent_collections);

                $('#total_rent').text('Ksh 0');
                $('#total_rent').text($('#total_landlord_rent').val());

            },
            error: function () {
                alert("error!!!!");
            }
        });






    });

</script>
@endpush