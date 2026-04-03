@if (count($bills) > 0)
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Saved Bills For House No : <u></u> </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm mb-0">
                <thead>
                    <tr>
                        <th>Bill Name</th>
                        <th>Bill Amount</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($bills as $bill)
                    <tr>
                        <td>{{ $bill->billing_name }}</td>
                        <td>{{ $bill->billing_amount }}</td>
                        <td>                            
                            <button type="button" class="btn btn-danger btn-sm delete-bill" data-id="{{$bill->id}}"
                            data-token="{{ csrf_token() }}"
                            >Del</button> 

                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@else

<section class="dash-section">
    <div class="dash-sec-content">
        <div class="dash-info-list">
            <div class="dash-card text-danger">
                <div class="dash-card-container">
                    <div class="dash-card-icon">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="dash-card-content">
                        <p>No saved Bills For This House</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif