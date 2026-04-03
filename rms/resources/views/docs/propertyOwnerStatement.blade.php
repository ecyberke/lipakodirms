<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Lesa Property Agency - Property Owner Statement </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{-- <link href=" {{ asset('assets/css/invoice_bootstrap.min.css') }} " rel="stylesheet" type="text/css" /> --}}
    <link href=" {{ asset('assets/css/invoice_style.css') }} " rel="stylesheet" type="text/css" />
    <style>
    .table-striped th, .table-striped td {
    padding: 0;
}
    </style>
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>Property Owner Statement</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Property Owner Name:</strong> <span>{{$other_info['name'] }}</span></p>
                            <p><strong>Property Name:</strong> <span>{{$other_info['apart_name']}}</span></p>
                            <p><strong>Telephone:</strong> <span>{{$other_info['phone'] }}</span></p>
                            <p><strong>Date of Statement:</strong> <span>{{$other_info['date'] }}</span></p>
                            <p><strong>Statement Period:</strong> <span>{{$other_info['from_to'] }}</span></p>
                        </div> <!-- end col -->
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                            <div class="mt-3 float-right">
                                <img src="{{URL::asset('assets/images/les.png')}}" alt="" height="100">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Detailed Statement</h4>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Reference</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <!--<th>Commission</th>-->
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($property_owner_info_array_info as $entry)
                              <tr>
                                <td>{{$entry['date']}}</td>
                                <td>{{$entry['description']}}</td>
                                <td>{{$entry['reference']}}</td>
                                <td>{{$entry['amount']}}</td>
                                <td>{{$entry['paid']}}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Summary</h4>
                        </div>
                    </div>
                    <div class="row">
                       <table class="table table-striped">
                            <thead>
                              <tr>
                                <td>Details</td>
                                <td >Amount</td>
                                <td >Paid</td>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Rent</td>
                                    <td >{{$totals['rent']}}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Bills</td>
                                    <td >-</td>
                                    <td >{{$totals['maintenance']}}</td>
                                </tr>
                                <tr>
                                    <td>Commission</td>
                                    <td >-</td>
                                    <td >{{$totals['commission']}}</td>
                                    
                                </tr>
                                <tr>
                                    <th>Sub Total</th>
                                    <th >{{$totals['sum_amount']}}</th>
                                     <th >-</th>
                                </tr>
                                <tr>
                                    <th>Sum Remitance</th>
                                    <th >-</th>
                                    <th >{{$totals['sum_remitance']}}</th>
                                </tr>
                                <tr>
                                    <th>Balance</th>
                                    <th >{{$totals['balance']}}</th>
                                   
                                </tr>
                            </tbody>
                          </table>
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html>