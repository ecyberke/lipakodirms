@extends('super_admin.layouts.master')
@section('title', 'Subscription Plans')
@section('page-title', 'Subscription Plans')

@section('content')
<div class="table-card">
    <p class="text-muted">Adjust pricing tiers. Changes take effect on next subscription renewal.</p>
    <table class="table">
        <thead class="table-light">
            <tr><th>Plan</th><th>Units Min</th><th>Units Max</th><th>Price/Unit/Month (KES)</th><th>Active</th><th>Action</th></tr>
        </thead>
        <tbody>
        @foreach($plans as $plan)
        <tr>
            <form method="POST" action="{{ route('super.plans.update', $plan->id) }}">
                @csrf @method('PUT')
                <td><input type="text" name="name" class="form-control form-control-sm" value="{{ $plan->name }}"></td>
                <td><input type="number" name="units_min" class="form-control form-control-sm" value="{{ $plan->units_min }}"></td>
                <td><input type="number" name="units_max" class="form-control form-control-sm" value="{{ $plan->units_max }}" placeholder="unlimited"></td>
                <td><input type="number" name="price_per_unit" class="form-control form-control-sm" value="{{ $plan->price_per_unit }}" step="0.01"></td>
                <td>
                    <select name="is_active" class="form-select form-select-sm">
                        <option value="1" {{ $plan->is_active ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$plan->is_active ? 'selected' : '' }}>No</option>
                    </select>
                </td>
                <td><button type="submit" class="btn btn-sm btn-primary">Update</button></td>
            </form>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
