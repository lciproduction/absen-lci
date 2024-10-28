@props(['title'])

<div {!! $attributes->merge(['class' => 'card w-[97%] lg:w-[90%]']) !!}>
    <div class="card-body">
        <h2 class="card-title">{{ $title ?? '' }}</h2>
        {{ $slot }}
    </div>
</div>
