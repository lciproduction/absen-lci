@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'select select-bordered  border text-base-content',
]) !!}>
    {{ $slot }}

</select>
