@props(['method'])

<form method="{{ $method ?? 'POST' }}" {!! $attributes->merge(['class' => '']) !!}>
    {{ $slot }}
</form>
