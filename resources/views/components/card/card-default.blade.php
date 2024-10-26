@props(['title'])

<div {!! $attributes->merge(['class' => 'card shadow-xl w-[90%] lg:w-[80%]']) !!}>
    <div class="card-body">
        <h2 class="card-title">{{ $title ?? '' }}</h2>
        {{ $slot }}
    </div>
</div>
