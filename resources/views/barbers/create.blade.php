<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-semibold">Crear Barbero</h1>
    </x-slot>

    <div class="container mx-auto p-5">
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 border-l-4 border-red-500 p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barbers.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-semibold mb-1">Nombre</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="photo" class="block font-semibold mb-1">Foto (opcional)</label>
                <input type="file" id="photo" name="photo" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                    class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-400">Guardar</button>
                <a href="{{ route('barbers.index') }}"
                    class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-400">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
