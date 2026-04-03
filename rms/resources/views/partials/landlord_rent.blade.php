@if (count($rents) > 0)

<table class="table table-bordered table-sm table-nowrap mb-0">
    <thead>
        <tr>
            <th style="width:40%">Property</th>
            <th>Total Collected</th>
            <th style="width:5%">Mng %</th>
            <th>Owner's Share</th>

        </tr>
    </thead>

    @php
     $total_fee=0;
    @endphp
    <tbody>

        @foreach ($rents as $rent)
        <tr>
        <td> {{ $rent->apartment->name }}</td>
            <td>Ksh {{ number_format($rent->rent_paid) }}</td>
            <td>{{ $rent->apartment->management_fee_percentage }}</td>
            <td>Ksh {{ number_format($rent->rent_paid *((100-$rent->apartment->management_fee_percentage)/100) ) }}</td>
            
        </tr>

         @php
            $total_fee += ($rent->rent_paid *((100-$rent->apartment->management_fee_percentage)/100) )
        @endphp
        
        @endforeach


    </tbody>
</table>
<input type="hidden" id="total_landlord_rent" value="Ksh {{ number_format($total_fee) }}">

@else

@endif