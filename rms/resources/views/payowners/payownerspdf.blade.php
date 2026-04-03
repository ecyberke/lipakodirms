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
                                            <p class="m-b-10"><strong>Generated On : </strong> <span
                                                    class="float-right">
                                                    {{$invoice->created_at }}</span></p>
                                            <p class="m-b-10"><strong>Invoice Due Date : </strong> <span
                                                    class="float-right" style="color: red;">
                                                   5th {{ \Carbon\Carbon::createFromFormat('M-Y',$invoice->rent_month)->format('M-Y') }}</span></p>
                                            <p class="m-b-10"><strong>Payment Status : </strong>
                                                <span
                                                class="float-right">
                                                    @if ($invoice->is_paid===1)
                                                    <span style="color: seagreen;">Paid</span>
                                                    @else
                                                    <span style="color: red;">Unpaid</span>
                                                    @endif



                                                </span></p>
                                            <p class="m-b-10"><strong>Invoice No. : </strong> <span
                                                    class="float-right" style="color: royalblue;">#{{ $invoice->id}} </span></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                              <div class="row mt-3">
                                    <div class="col-xs-4">
                                        <p><b>Tenant Details</b> </p>
                                        <address>
                                            {{ $invoice->tenant->full_name}}<br>
                                            Email: {{ $invoice->tenant->email}}<br>
                                            Phone Number: +{{ $invoice->tenant->id}}<br>
                                          
                                        </address>
                                    </div> <!-- end col -->

                                    <div class="col-xs-6">
                                        <p><b>House Details</b> </p>
                                        <address>
                                           
                                            House No: {{ $invoice->house->house_no }}<br>
                                            House Type: {{ $invoice->house->house_type }}<br>
                                            Building: {{ $invoice->house->apartment->name }}<br> 
                                            Town: {{ $invoice->house->apartment->town }}<br>                                            
                                        </address>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table mt-4 table-centered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">#</th>
                                                        <th>Bill Description</th>
                                                        <th style="width: 30%" class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <b>House Rent</b>
                                                        </td>
                                                        <td class="text-right">Ksh {{ number_format($invoice->rent)}}
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td>2</td>
                                                        <td>
                                                            <b>Late Payment Penalty (15%)</b>
                                                        </td>
                                                        <td class="text-right">Ksh
                                                            {{ number_format($invoice->penalty_fee)}}</td>
                                                    </tr> --}}

                                                    @php
                                                    $count=3;
                                                    @endphp

                                                    @forelse ($billings as $billing)


                                                    <tr>
                                                        <td> {{ $count++ }}</td>
                                                        <td><b> {{ $billing->billing_name}} </b></td>
                                                        <td class="text-right">Ksh
                                                            {{ number_format($billing->billing_amount )}}</td>
                                                    </tr>

                                                    @empty

                                                    @endforelse


                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive -->
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-xs-9">
                                        <div class="clearfix pt-5">
                                            <h6 class="text-muted">Notes:</h6>

                                            <small class="text-muted">
                                                To be paid by  MPesa Paybill Number <b>743994</b>.<br>
                                                The invoiced tenant has a balance of <strong>Ksh {{number_format((($invoice->paid_in - ($invoice->total_payable + $invoice->penalty_fee) )) *-1)}}<</strong> <br />
                                            
                                            </small>
                                        </div>
                                        
                                    </div> <!-- end col -->
                                    <div class="col-xs-3  float-right" style="float:right;text-align:right;">
                                        <div class="mt-3 float-right">
                                            <p class="m-b-10"><b>Sub-total:</b> <span class="float-right">Ksh {{ number_format($invoice->rent + $invoice->bills + $invoice->penalty_fee)  }}</span></p>
                                            <p class="m-b-10"><b>Tax:</b> <span class="float-right"> Ksh 0.00</span></p> <hr>
                                            <p class="m-b-10"><b>To pay:</b> <span class="float-right"> Ksh {{ number_format($invoice->rent + $invoice->bills + $invoice->penalty_fee)  }} </span></p>
                                            <p class="m-b-10"><b>Total Paid:</b> <span class="float-right"> Ksh {{number_format($invoice->paid_in)}} </span></p>
                                            <p class="m-b-10"><b>Balance:</b> <span class="float-right"> Ksh {{number_format((($invoice->paid_in - ($invoice->total_payable + $invoice->penalty_fee) )) *-1)}} </span></p>
                                        </div>
                                    </div>
                                    {{-- <div  class="col-xs-3 offset-xs-2">
                                        <div class="mt-3 float-right">
                                        <div class="float-right">
                                            
                                        </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div> <!-- end col --> --}}
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