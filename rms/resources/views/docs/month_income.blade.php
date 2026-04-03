<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Lesa Property Agency - Monthly Properties Income Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{-- <link href=" {{ asset('assets/css/invoice_bootstrap.min.css') }} " rel="stylesheet" type="text/css" /> --}}
    <link href=" {{ asset('assets/css/invoice_style.css') }} " rel="stylesheet" type="text/css" />
    
    <style>
.table-hover th, .table-hover td {
    padding: 0;
}
.table-info{
    background-color: #86cfda;
}
</style>
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>Agency Status Report</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Report Month:</strong> <span>{{$rent_month}}</span></p>
                            <p><strong>Total Earnings:</strong> <span>{{number_format($total_paid_in)}}</span></p>
                        </div> <!-- end col -->
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                             <div class="mt-3 float-right">
                                <img src="{{URL::asset('assets/images/les.png')}}" alt="" height="100">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-hover">
                           <thead>
                              <tr>
                               
                                <th>Property Name</th>
                                <th>Property Owner</th>
                                <th>Income Month</th>
                                <th class="text-right">Total Expected</th>
                                <th class="text-right">Total Paid</th>
                                <th class="text-right">Outstanding Balance</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($entries as $entry)
                              <tr>
                                
                                <th>{{$entry['apartment_name']}}</th>
                                <td>{{$entry['land_lord']}}</td>
                                <td>{{$rent_month}}</td>
                                <td class="text-right">{{number_format($entry['total_payable'])}}</td>
                                <td class="text-right">{{number_format($entry['paid_in'])}}</td>
                                <td class="text-right">{{number_format($entry['balance'])}}</td>
                              </tr>
                              @endforeach
                              <tr>
                                <th >Totals</th>
                                 <th></th>
                                 <th></th>
                                <th class="text-right">{{number_format($totals['total_payable'])}}</th>
                                <th class="text-right">{{number_format($totals['total_paid_in'])}}</th>
                                <th class="text-right">{{number_format($totals['total_balance'])}}</th>
                              </tr>
                            </tbody>
                          </table>
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html>