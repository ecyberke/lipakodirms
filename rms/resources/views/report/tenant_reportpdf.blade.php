<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>LIA Tenant Report</title>
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
                                        <div class="col-xs-4">
                                            <p><b>Tenant Details</b> </p>
                                            <address>
                                        
                                                {{ $invoices[0]->tenant->full_name}}<br>
                                                {{-- Email: {{ $invoices[0]->tenant->email}}<br> --}}
                                                Phone Number: +{{ $invoices[0]->tenant->id}}<br>
                                              
                                            </address>
                                        </div>

                                    </div><!-- end col -->
                                    <div class="col-xs-4 offset-xs-2 float-right" style="float:right;text-align:right;">
                                        <div class="mt-3 float-right">
                                            <p class="m-b-10"><strong>Generated On : </strong><br> <span
                                                    class="float-right"> {{ \Carbon\Carbon::now() }} </span> </p>
                                            
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                              <div class="row mt-3">
                              
                                   <!-- end col -->

                                    <div class="col-xs-6">
                                        <p><b>House Details</b> </p>
                                        <address>
                                           @foreach($invoices as $invoice)
                                            House No: {{ $invoice->house->house_no }}<br>
                                            House Type: {{ $invoice->house->house_type }}<br>
                                            Building: {{ $invoice->house->apartment->name }}<br> 
                                            Town: {{ $invoice->house->apartment->town }}<br> 
                                            <hr/>   
                                            @endforeach                                        
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
                                                        <th>Type</th>
                                                        <th>Transaction Code</th>
                                                        <th>Invoice Number</th>
                                                        <th>Amount</th>
                                                        <th>Date Paid</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @if(count($tenant_payments) > 0)
@foreach($tenant_payments as $payment)
<tr>
<td>{{$payment->TransactionType}}</td>
<td>{{$payment->TransID}}</td>
<td>{{$payment->InvoiceNumber}}</td>
<td>{{number_format($payment->TransAmount)}}</td>
<td>{{$payment->created_at}}</td>
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
                                            Total Amount Paid &nbsp;<strong>Ksh {{number_format($tenant_payments->sum('TransAmount'))}}</strong> <br />
                                            
                                            </small>
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