<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-red-500 px-4 py-2 rounded-md border-2 border-red-500 hover:bg-black hover:text-red-500 hover:border-2 hover:border-red-500 transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>
