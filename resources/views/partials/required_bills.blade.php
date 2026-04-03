@forelse ($house->bills as $bill)

<div class="form-group row mb-4">
        <label for="example-text-input" class="col-sm-4 col-form-label">{{ $bill->name }}</label>
        <div class="col-sm-8">
        <input class="form-control" type="text" id="example-text-input" disabled value="Ksh {{number_format($bill->pivot->amount) }}">
        </div>
    </div>
    
@empty
    
@endforelse