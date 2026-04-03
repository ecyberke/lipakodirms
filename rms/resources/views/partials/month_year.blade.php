<div class="col-6">
    <div class="form-group form-focus select-focus">
        <select class="select floating" name="month">            
            <option>January</option>
            <option>February</option>
            <option>March</option>
            <option>April</option>
            <option>May</option>
            <option>June</option>
            <option>July</option>
            <option>August</option>
            <option>September</option>
            <option>October</option>
            <option>November</option>
            <option>Decemeber</option>
        </select>
        <label class="focus-label">Select Month</label>
    </div>
</div>
<div class="col-6">
    <div class="form-group form-focus select-focus">
        <select class="select floating" name="year">           

            @for ($i = 2019; $i < 2026 ; $i++)
                <option>{{ $i}}</option>
            @endfor          
         </select>
        <label class="focus-label">Select Year</label>
    </div>
</div>