@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'text-black border-2 border-gray rounded-md focus:border-yellow']) }}>
