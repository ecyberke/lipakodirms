@extends('tenant.layouts.master')
@section('title', 'Add Request')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="{{ route('tenant.service-requests.store') }}" class="card">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        @include('includes.messages')

                        {{-- Property & House --}}
                        <div class="row">
                            @if($assignments->count() > 1)
                            <div class="col-sm-6">
                                <label>Select Property <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search" style="width:100%" name="apartment_id" id="apartment_select">
                                    <option selected disabled>-----Select-----</option>
                                    @foreach($assignments->unique('apartment_id') as $assign)
                                    <option value="{{ $assign->apartment_id }}">
                                        {{ $assign->house->apartment->name ?? 'Property' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Select House</label>
                                <select class="form-control select2-show-search" style="width:100%" name="house_id" id="houses_select" required>
                                    <option selected disabled>-----Select Property First-----</option>
                                    @foreach($assignments as $assign)
                                    <option value="{{ $assign->house_id }}" data-apt="{{ $assign->apartment_id }}">
                                        {{ $assign->house->house_no ?? 'Unit' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                            @php $assign = $assignments->first(); @endphp
                            <input type="hidden" name="house_id" value="{{ $assign?->house_id }}">
                            <input type="hidden" name="apartment_id" value="{{ $assign?->apartment_id }}">
                            <div class="col-sm-6">
                                <label>Property</label>
                                <input type="text" class="form-control" value="{{ $assign?->house?->apartment?->name ?? 'N/A' }}" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label>House No.</label>
                                <input type="text" class="form-control" value="{{ $assign?->house?->house_no ?? 'N/A' }}" readonly>
                            </div>
                            @endif
                        </div><br>

                        {{-- Tenant (readonly) --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Tenant</label>
                                <input type="text" class="form-control" value="{{ $tenant->full_name }}" readonly>
                            </div>
                        </div><br>

                        {{-- Service Requested --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Service Requested <span class="text-danger">*</span></label>
                                <select name="service_type" class="form-control select2-show-search" required>
                                    <option selected disabled>-----Select-----</option>
                                    <option value="Plumbing">Plumbing</option>
                                    <option value="Electrical">Electrical</option>
                                    <option value="Sewerage">Sewerage</option>
                                    <option value="Carpentry">Carpentry</option>
                                </select>
                            </div>
                        </div><br>

                        {{-- Affected Area --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Affected Area <span class="text-danger">*</span></label>
                                <select name="affected_area" class="form-control select2-show-search" required>
                                    <option selected disabled>-----Select-----</option>
                                    <option value="Living Room">Living Room</option>
                                    <option value="Kitchen">Kitchen</option>
                                    <option value="Bedroom">Bedroom</option>
                                    <option value="Bathroom">Bathroom</option>
                                    <option value="Toilet/Bathroom">Toilet/Bathroom</option>
                                    <option value="Roofing">Roofing</option>
                                    <option value="Walls">Walls</option>
                                    <option value="Whole House">Whole House</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div><br>

                        {{-- Details --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Details <span class="text-danger">*</span></label>
                                <input type="text" name="service_request" class="form-control" required>
                            </div>
                        </div><br>

                        {{-- Priority --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Priority <span class="text-danger">*</span></label>
                                <select name="priority" class="form-control select2-show-search" required>
                                    <option selected disabled>-----Select-----</option>
                                    <option value="1">Urgent</option>
                                    <option value="2">Not Urgent</option>
                                </select>
                            </div>
                        </div><br>

                        <input type="hidden" name="status" value="0">
                        <input type="hidden" name="approval" value="0">

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-success">Add Request</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script>
$(function() {
    $('#apartment_select').change(function() {
        var aptId = $(this).val();
        $('#houses_select option[data-apt]').each(function() {
            $(this).toggle($(this).data('apt') == aptId);
        });
        $('#houses_select').val('');
    });
});
</script>
@endsection
