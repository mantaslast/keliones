@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Sveiki!')
@endif
@endif

{{-- Intro Lines --}}

Gavote šį El. Laišką, nes gavome užklausą iš naujo nustatyti paskyros slaptažodį.


{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
Atstatyti slaptažodį
@endcomponent
@endisset

{{-- Outro Lines --}}
Šios slaptažodžio atstatymo nuorodos galiojimo laikas baigsis po 60 minučių.<br>
Jei neprašėte slaptažodžio atstatymo, jokių tolesnių veiksmų atlikti nereikia.


{{-- Salutation --}}
@if (! empty($salutation))
@else
@lang('Linkėjimai'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Jeigu nepavyksta paspausti \":actionText\" mygtuko, nukopijuokite nuorodą apačioje\n".
    'ir įklijuokite į naršyklės paieškos laukelį:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
