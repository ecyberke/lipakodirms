@extends('layouts.home')

@push('header_scripts')
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">

@endpush

@section('content')
<div class="content container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="">Prepare Invoice For Each Occupied House</h4>
        </div>
    </div>
    <!-- /Page Title -->

    <!-- Content Starts -->

    <form action="{{route('monthlybills.store')}}" method="post">



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Allocate Units </h4>
                        <p class="text-muted m-b-30 font-14">After Successful registration,you will be
                            redirected to a page where you will assign the New Tenant A Unit / Units.
                        </p>
                        <div class="p-20">
                            <div class="row mb-4">

                                {{ csrf_field() }}
                                <div class="col-3">
                                    <div class="form-group form-focus select-focus ">


                                        <select class="select" id="apartment_id" name="apartment">

                                            <option selected disabled></option>

                                            @forelse ($apartments as $apartment=>$key)
                                            <option value="{{$key}}">{{ $apartment}}</option>
                                            @empty

                                            @endforelse

                                        </select>

                                        <label class="focus-label">Select Apartment</label>

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group form-focus select-focus">

                                        <select class="select select floating" name="house_id" id="houses_select">

                                        </select>
                                        <label class="focus-label">Select House No</label>

                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group form-focus select-focus">
                                        <select class="select floating" name="bill_month" id="bill-month">
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
                                <div class="col-2">
                                    <div class="form-group form-focus select-focus">
                                        <select class="select floating" name="bill_year" id="bill-year">

                                            @for ($i = 2019; $i < 2026 ; $i++) <option>{{ $i}}</option>
                                                @endfor
                                        </select>
                                        <label class="focus-label">Select Year</label>
                                    </div>
                                </div>
                                
                                <div class="col-2">
                                    <button type="button" class="btn btn-secondary btn-block" id="btn-search">View Saved
                                        Bills</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-4">Tenants Bills Incurred</h4>
                        @include('includes.messages')
                        <table class="table table-borderless table-review  review-table mb-3" id="table_goals">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:10px;">#</th>
                                    <th>Bill Name</th>
                                    <th>Amount Incurred</th>
                                    <th>Attachments</th>
                                    <th style="width: 64px;"><button type="button"
                                            class="btn btn-primary btn-add-row"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody id="table_goals_tbody">

                            </tbody>
                        </table>

                        <div class="text-center">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>

                    </div>
                </div>
            </div>
</form>
            <div class="col order-first">
                <div class="row">
                    <div class="col-8" id="column-results">

                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-3">
           <a href="/make-invoice"><button type="button" class="btn btn-success btn-block" id="btn-search">Generate Invoice</button></a> 
        </div>
        
    


    <!-- /Content End -->

</div>
@endsection

@push('footer_scripts')
<script>
    $('#apartment_id').change(function () {
        var id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{!! route('ajax.houses.occupied') !!}",
            method: 'POST',
            data: { 'id': id, '_token': token },
            success: function (data) {
                $('#section-bills').html('');
                $("select[name='house_id']").html('');
                $("select[name='house_id']").html(data.options);
            },
            error: function () {
                alert("error!!!!");
            }
        });
    });

    $('#houses_select').change(function () {
        var id = $(this).val();
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{!! route('ajax.house.bills') !!}",
            method: 'POST',
            data: { 'id': id, '_token': token },
            success: function (data) {
                $('#section-bills').html('');
                $('#section-bills').html(data.options);
            },
            error: function () {
                alert("error!!!!");
            }
        });

    });

    $(document).on("click", '.btn-add-row', function () {
        var id = $(this).closest("table.table-review").attr('id');  // Id of particular table        
        console.log(id);
        var div = $("<tr />");
        div.html(GetDynamicTextBox(id));
        $("#" + id + "_tbody").append(div);
    });
    $(document).on("click", "#comments_remove", function () {
        $(this).closest("tr").prev().find('td:last-child').html('<button type="button" class="btn btn-danger" id="comments_remove"><i class="fa fa-trash-o"></i></button>');
        $(this).closest("tr").remove();
    });

    function GetDynamicTextBox(table_id) {
        $('#comments_remove').remove();
        var rowsLength = document.getElementById(table_id).getElementsByTagName("tbody")[0].getElementsByTagName("tr").length + 1;
        return '<td>' + rowsLength + '</td>' + `
        <td><input type="text" name = "bill_name[]" class="form-control text-uppercase"></td>'
         + '<td><input type="text" name = "bill_amount[]" class="form-control"></td>' 
         + '<td><input type="file" name = "" class="form-control"></td>'
         + '<td><button type="button" class="btn btn-danger" id="comments_remove">
            <i class="fa fa-trash-o"></i></button>
            </td>`
    }


    $(document).on("click",'.delete-bill', function () {      
        
        
        if (confirm('Do you want to delete')) {
              var id = $(this).data("id");
              var token = $(this).data("token");
             $.ajax({
            url: "{!! route('monthlybills.delete') !!}",
            method: 'DELETE',
            data: { 'id': id, '_token': token },


            success: function (data) {
              $('#section-bills').html('');
              console.log('deleted');
              $("#btn-search").click();
            },
            error: function () {
                alert("error!!!!");
            }
         });



        }

    });


    $('#btn-search').on("click", function () {
        var token = $("input[name='_token']").val();
        var house_id = $("#houses_select :selected").val();
        var month = $("#bill-month :selected").val();
        var year = $("#bill-year :selected").val();
        $.ajax({
            url: "{!! route('ajax.house.monthlybills') !!}",
            method: 'POST',
            data: { 'house_id': house_id, '_token': token, 'month': month, 'year': year },
            success: function (data) {
                $('#column-results').html('');
                $("#column-results").html(data.options);
            },
            error: function () {
                alert("error!!!!");
            }
        });
    });



</script>
@endpush