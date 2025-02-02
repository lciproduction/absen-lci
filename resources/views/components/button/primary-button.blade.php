<button {!! $attributes->merge(['class' => 'btn bg-red-secondary hover:bg-red-primary/80 text-white']) !!}>
    {{ $slot }}
</button>
