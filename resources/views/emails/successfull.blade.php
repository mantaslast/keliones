@component('mail::message')
# Jūsų užsakymas Kelionės.lt

Sėkmingai atlikote rezervaciją!<br>
Apie užsakymo būsenos pasikeitimus pranešime jums el. paštu. <br>
<br>
Jūsų užsakymo numeris - <a href="{{ $link }}">{{ $order->key }}</a> 

Dėkojame,<br>
{{ config('app.name') }}
@endcomponent
