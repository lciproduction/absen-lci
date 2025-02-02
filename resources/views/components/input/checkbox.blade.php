@props(['title', 'value'])

<span class="label-text text-red-primary">{{ $title ?? '' }}</span>
<input type="checkbox" {{ $value ?? '' }} {{ $attributes->merge(['class' => 'checkbox']) }} />
