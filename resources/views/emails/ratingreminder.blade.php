@component('mail::message')
# {{ $title }}

{!! $body !!}

Dėkojame,<br>
{{ config('app.name') }}
@endcomponent
