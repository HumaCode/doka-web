<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
<h1 style="color: #4f46e5; font-size: 22px; margin-bottom: 20px;">{{ $greeting }}</h1>
@else
@if ($level === 'error')
<h1 style="color: #ef4444; font-size: 22px; margin-bottom: 20px;">@lang('Whoops!')</h1>
@else
<h1 style="color: #4f46e5; font-size: 22px; margin-bottom: 20px;">Halo! 👋</h1>
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards,')<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
