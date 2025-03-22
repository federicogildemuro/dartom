<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-semibold">Lista de Barberos</h1>
    </x-slot>

    <div class="container mx-auto p-5">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border-l-4 border-green-500 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('barbers.create') }}"
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-400 mb-5 inline-block">
            Agregar Barbero
        </a>

        @if ($barbers->isEmpty())
            <p class="text-lg">No hay barberos registrados.</p>
        @else
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">Nombre</th>
                        <th class="px-4 py-2 border-b">Correo</th>
                        <th class="px-4 py-2 border-b">Foto</th>
                        <th class="px-4 py-2 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barbers as $barber)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">{{ $barber->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $barber->email }}</td>
                            <td class="px-4 py-2 border-b flex justify-center items-center">
                                <img src="{{ asset('storage/' . ($barber->photo ?? 'barbers/default.webp')) }}"
                                    alt="Foto de {{ $barber->name }}" class="w-12 h-12 object-cover rounded-full">
                            </td>
                            <td class="px-4 py-2 border-b text-center space-x-2">
                                <a href="{{ route('barbers.edit', $barber->id) }}"
                                    class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-400 inline-block">
                                    Editar
                                </a>

                                <form action="{{ route('barbers.destroy', $barber->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-400 inline-block"
                                        onclick="return confirm('¿Seguro que deseas eliminar este barbero?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
