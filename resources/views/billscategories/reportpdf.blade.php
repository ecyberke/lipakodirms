<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>LIA Invoices</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{-- <link href=" {{ asset('assets/css/invoice_bootstrap.min.css') }} " rel="stylesheet" type="text/css" /> --}}
    <link href=" {{ asset('assets/css/invoice_style.css') }} " rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <!-- Logo & title -->
                                <div class="clearfix">
                                    <div class="float-left">
                                  <img src="https://lesaagencies.co.ke/rms/assets/img/lesa.png" alt="" height="100">
                                   {{-- <h3>LESA INTERNATIONAL AGENCY</h3> --}}
                                    </div>
                                    <div class="float-right">
                                        {{-- <h3 class="m-0 d-print-none">Invoice</h3> --}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        {{-- <div class="mt-3">
                                            <p><b>Hello, {{ $invoice->tenant->full_name}}</b></p>
                                            <p class="text-muted">Thanks a lot for being our esteemed tenant.
                                                Our company
                                                promises to provide high quality service for you as well as outstanding
                                                customer service for every transaction. </p>
                                        </div> --}}

                                    </div><!-- end col -->
                                    <div class="col-xs-4 offset-xs-2 float-right" style="float:right;text-align:right;">
                                        <div class="mt-3 float-right">
                                            
                                            
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                              <div class="row mt-3">
                                    <div class="col-xs-4">
                                        <p><b></b> </p>
                                        <address>
                                            {{-- {{ $invoice->tenant->full_name}}<br>
                                            Email: {{ $invoice->tenant->email}}<br>
                                            Phone Number: +{{ $invoice->tenant->id}}<br> --}}
                                          
                                        </address>
                                    </div> <!-- end col -->

                                    <div class="col-xs-6">
                                        <p><b></b> </p>
                                        <address>
                                           
                                            {{-- House No: {{ $invoice->house->house_no }}<br>
                                            House Type: {{ $invoice->house->house_type }}<br>
                                            Building: {{ $invoice->house->apartment->name }}<br> 
                                            Town: {{ $invoice->house->apartment->town }}<br>                                             --}}
                                        </address>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped"
                                            
                                            >
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>Name</th>
                                                        <th>House</th>
                                                        <th>Service Status</th>
                                                        <th>Phone</th>
                                                        <th> Req. Number</th>
                                                        <th>Req. Date</th>
                                                        <th>Expense Amount</th>
                                                   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   {{-- @if(count($service_requests) > 0) --}}

<tr>
    <td>{{$service_requests->tenant->full_name}}</td>
    <td>{{$service_requests->house->house_no}}</td>
    <td>@if($service_requests->status == 1)
        <p style="color: #FF0000;">Closed</p>
        @elseif($service_requests->status == 2)
        <p style="color: #00bfff;">In Progress</p>
        @elseif($service_requests->status == 0)
        <p style="color: #66CD00;">Open</p>
        @endif</td>
    <td>{{$service_requests->tenant->id}}</td>
<td>{{$service_requests->id}}</td>
<td>{{$service_requests->requested_date}}</td>
<td>{{$service_requests->amount}}</td>

</tr>

                                                   {{-- @else 

                                                   @endif --}}


                                                </tbody>
                                            </table>
                                            <hr>
                                            <div class="job-desc-title">
                                                <h4>&nbsp; Requested Service</h4>
                                            </div>
                                            <div class="">
                                                <p>&nbsp; {{$service_requests->service_request}} </p>
                                            </div>
                                            <div class="job-desc-title">
                                                <h4>&nbsp; Payment Status</h4>
                                            </div>

                                            <div class="">
                                                <p>&nbsp;  @if($service_requests->pay_status == 0)
                                                    <span style="color: #FF0000;">Unpaid</span>
                                                    @elseif($service_requests->pay_status == 1)
                                                    <span style="color: #66CD00;">Paid</span>
                                                    @elseif($service_requests->pay_status == 2)
                                                    <span style="color: #00bfff;">Partial</span>
                                                    @endif</p>
                                            </div>
                                        </div> <!-- end table-responsive -->
                                    </div> <!-- end col -->
                                </div>
                               
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-xs-9">
                                        <div class="clearfix pt-5">
                                          

                                            
                                        </div>
                                        
                                    </div> <!-- end col -->
                                   
                                   
                                </div>
                                <!-- end row -->
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html>