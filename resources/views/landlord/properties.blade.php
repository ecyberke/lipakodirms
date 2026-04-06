@extends('landlord.layouts.master')
@section('title', 'My Properties')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Properties List --}}
        <div class="card" id="properties-list">
            <div class="card-body">
                <table class="table table-striped custom-table mb-0" id="prop-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Property Name</th>
                            <th>Location</th>
                            <th>Total Units</th>
                            <th>Occupied</th>
                            <th>Vacant</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @forelse($apartments as $apt)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td><strong>{{ $apt->name }}</strong></td>
                        <td>{{ $apt->location }}</td>
                        <td><span class="badge badge-primary">{{ $apt->houses->count() }}</span></td>
                        <td><span class="badge badge-success">{{ $apt->houses->where('is_occupied', 1)->count() }}</span></td>
                        <td><span class="badge badge-danger">{{ $apt->houses->where('is_occupied', 0)->count() }}</span></td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item">
                                        <a class="btn btn-sm btn-info btn-block" href="#"
                                            onclick="showUnits({{ $apt->id }}, '{{ addslashes($apt->name) }}'); return false;">
                                            View Units
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted">No properties found</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Units Panel (hidden by default) --}}
        <div class="card" id="units-panel" style="display:none;">
            <div class="card-header">
                <h4 class="card-title" id="units-title">Units</h4>
                <div class="card-options">
                    <a href="#" class="btn btn-sm btn-secondary" onclick="hideUnits(); return false;">
                        <i class="fe fe-arrow-left"></i> Back to Properties
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="units-table">
                        <thead>
                            <tr>
                                <th>House No</th>
                                <th>Type</th>
                                <th>Rent</th>
                                <th>Tenant</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="units-tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden data --}}
<script>
var apartmentsData = {
    @foreach($apartments as $apt)
    {{ $apt->id }}: {
        name: "{{ addslashes($apt->name) }}",
        houses: [
            @foreach($apt->houses as $house)
            @php
                $ht = $house->house_tenant;
                $tenant = $ht ? \App\Tenant::find($ht->tenant_id) : null;
            @endphp
            {
                house_no: "{{ $house->house_no }}",
                type: "{{ $house->house_type ?? 'N/A' }}",
                rent: "{{ $org->currency ?? 'KES' }} {{ number_format($house->house_rent ?? 0) }}",
                tenant: "{{ $tenant?->full_name ?? 'Vacant' }}",
                on_notice: {{ $house->on_notice ? 'true' : 'false' }},
                is_occupied: {{ $house->is_occupied ? 'true' : 'false' }},
            },
            @endforeach
        ]
    },
    @endforeach
};

function showUnits(aptId, aptName) {
    var apt = apartmentsData[aptId];
    document.getElementById('units-title').innerText = aptName + ' — Units';
    var tbody = document.getElementById('units-tbody');
    tbody.innerHTML = '';
    apt.houses.forEach(function(h) {
        var status = h.on_notice
            ? '<span class="badge badge-warning">On Notice</span>'
            : (h.is_occupied ? '<span class="badge badge-success">Occupied</span>' : '<span class="badge badge-danger">Vacant</span>');
        tbody.innerHTML += '<tr><td><strong>' + h.house_no + '</strong></td><td>' + h.type + '</td><td>' + h.rent + '</td><td>' + h.tenant + '</td><td>' + status + '</td></tr>';
    });
    document.getElementById('properties-list').style.display = 'none';
    document.getElementById('units-panel').style.display = 'block';
}

function hideUnits() {
    document.getElementById('units-panel').style.display = 'none';
    document.getElementById('properties-list').style.display = 'block';
}
</script>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script>
$(function() { $('#prop-table').DataTable({"pageLength": 25}); });
</script>
@endsection
