@props(['title', 'value'])

<span class="label-text text-white">{{ $title ?? '' }}</span>
<input type="checkbox" {{ $value ?? '' }} {{ $attributes->merge(['class' => 'checkbox']) }} />
