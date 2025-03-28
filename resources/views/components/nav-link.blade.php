@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center font-bold scale-110 hover:text-yellow transition duration-150 ease-in-out'
            : 'inline-flex items-center hover:text-yellow transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
