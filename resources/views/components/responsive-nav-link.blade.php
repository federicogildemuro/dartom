@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full p-2 bg-white text-black border-l-4 border-yellow hover:text-gray transition duration-150 ease-in-out'
            : 'block w-full p-2 hover:text-gray transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
