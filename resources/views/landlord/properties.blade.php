@extends('landlord.layouts.master')
@section('title', 'My Properties')

@section('content')
@foreach($apartments as $apt)
<div class="content-card mb-4">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <h6>{{ $apt->name }}</h6>
            <small class="text-muted">{{ $apt->location }}</small>
        </div>
        <div>
            <span class="badge bg-success">{{ $apt->houses->where('is_occupied',1)->count() }} Occupied</span>
            <span class="badge bg-warning text-dark ms-1">{{ $apt->houses->where('is_occupied',0)->count() }} Vacant</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead class="table-light"><tr><th>Unit</th><th>Type</th><th>Rent</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($apt->houses as $house)
            <tr>
                <td>{{ $house->house_no }}</td>
                <td>{{ $house->house_type ?? 'N/A' }}</td>
                <td>{{ $org->currency ?? 'KES' }} {{ number_format($house->rent ?? 0) }}</td>
                <td>
                    @if($house->on_notice)
                        <span class="badge bg-warning text-dark">On Notice</span>
                    @elseif($house->is_occupied)
                        <span class="badge bg-success">Occupied</span>
                    @else
                        <span class="badge bg-secondary">Vacant</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
@endsection
