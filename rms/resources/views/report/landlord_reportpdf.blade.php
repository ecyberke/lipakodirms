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
                                    <h5>Statement for</h5><br/>
                                    <p>{{$landlord_report[0]->landlord->full_name}}</p>
                                        
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                              
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table mt-4 table-centered">
                                                <thead>
                                                    <tr>
                                                        <th>Rent</th>
                                                        <th>Fee %</th>
                                                        <th>Total Owned</th>
                                                        <th>Paid</th>
                                                        <th>Expenses</th>
                                                        <th>Balance</th>
                                                        <th>Month</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @if($landlord_report->count() > 0)
@foreach($landlord_report as $payment)
<tr>
<td>{{number_format($payment->rent)}}</td>
<td>{{$payment->mgt}}</td>
<td>{{number_format($payment->total_owned)}}</td>
<td>{{number_format($payment->paid_in)}}</td>
<td>{{number_format($payment->bills)}}</td>
<td>{{number_format($payment->balance)}}</td>
<td>{{$payment->rent_month}}</td>
</tr>
@endforeach
                                                   @else 

                                                   @endif


                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive -->
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-xs-9">
                                        <div class="clearfix pt-5">
                                            {{-- <h6 class="text-muted">Notes:</h6> --}}

                                            <small class="text-muted">
                                            Total Amount Paid &nbsp;<strong>Ksh {{number_format($landlord_report->sum('paid_in'))}}</strong> <br />
                                            
                                            </small>
                                            <div class="mt-3 float-right">
                                                
                                                
                                            </div>
                                        </div>
                                        
                                    </div> <!-- end col -->
                                   
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