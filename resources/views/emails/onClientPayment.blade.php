@component('mail::message')
# Introduction


{{-- {{$metadata->cats}} --}}

@component('mail::button', ['url' => $metadata->invoice_id])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
