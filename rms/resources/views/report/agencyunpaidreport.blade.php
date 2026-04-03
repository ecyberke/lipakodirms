<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>LIA Unpaid Houses Report</title>
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
                                            <p class="m-b-10"><strong>Generated On : </strong><br> <span
                                            class="float-right">{{\Carbon\Carbon::now()}}</span></p>
                                            
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                             
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="unpaid-invoices-table" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                     <th style="width:10%">#INV</th>
                                     <th>Tenant</th>
                                     <th>Property</th>
                                     <th>House</th>                                    
                                     <th>Balance</th>                                    
                                                                  
                                    
                                </tr>
                        </thead>
                        <tbody>
@foreach($invoices as $invoice)
<tr>
    <td>{{$invoice->id}}</td>
    <td>{{$invoice->tenant->full_name}}</td>
    <td>{{$invoice->apartment->name}}</td>
    <td>{{$invoice->house->house_no}}</td>
    <td>{{number_format($invoice->balance)}}</td>
</tr>
@endforeach
                        </tbody>
                    </table>
                                        </div> <!-- end table-responsive -->
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                 <!-- end col -->
                                   
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