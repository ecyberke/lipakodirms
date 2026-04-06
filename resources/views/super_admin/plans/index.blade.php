@extends('super_admin.layouts.master')
@section('title', 'Subscription Plans')
@section('page-title', 'Subscription Plans')

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Subscription Plans</h3>
                    <div class="card-options">
                        <small class="text-muted">Changes take effect on next subscription renewal</small>
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.messages')
                    <table class="table table-striped custom-table mb-0" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Plan Name</th>
                                <th>Units Min</th>
                                <th>Units Max</th>
                                <th>Price / Unit / Month (KES)</th>
                                <th>Active</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($plans as $plan)
                        <tr>
                            <form method="POST" action="{{ route('super.plans.update', $plan->id) }}">
                                @csrf @method('PUT')
                                <td><input type="text" name="name" class="form-control" value="{{ $plan->name }}"></td>
                                <td><input type="number" name="units_min" class="form-control" value="{{ $plan->units_min }}"></td>
                                <td><input type="number" name="units_max" class="form-control" value="{{ $plan->units_max }}" placeholder="unlimited"></td>
                                <td><input type="number" name="price_per_unit" class="form-control" value="{{ $plan->price_per_unit }}" step="0.01"></td>
                                <td>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ $plan->is_active ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$plan->is_active ? 'selected' : '' }}>No</option>
                                    </select>
                                </td>
                                <td class="text-right">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
