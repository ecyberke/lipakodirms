<option selected disabled>-------Select-------</option>
@forelse ($houses as $item)

<option value="{{$item->id}}">{{ $item->house_no}} - {{ $item->house_type }} </option>
@empty

@endforelse


