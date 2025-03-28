<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-yellow px-4 py-2 rounded-md border-2 border-yellow hover:bg-black hover:text-yellow transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>
