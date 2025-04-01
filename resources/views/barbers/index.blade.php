<x-app-layout>
    <section class="min-h-screen p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Barberos</h1>
        <p class="text-center mb-5">Acá podés ver y gestionar todos los barberos registrados.</p>

        <!-- Show success or error message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border-l-4 border-green-500 p-4 mb-4">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-100 text-red-800 border-l-4 border-red-500 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Add Barber Button -->
        <div class="flex flex-col items-center justify-center mb-5">
            <x-primary-button class="mb-5">
                <a href="{{ route('barbers.create') }}">Agregar Barbero</a>
            </x-primary-button>
        </div>

        <!-- If there are no barbers, show a message, otherwise show the list -->
        @if ($barbers->isEmpty())
            <p class="text-4xl font-bold text-yellow text-center mb-5">No hay barberos registrados</p>
        @else
            <div class="overflow-x-auto">
                <table class="text-sm sm:text-base w-full mb-5">
                    <thead class="text-yellow">
                        <tr>
                            <th class="px-2 py-1 sm:px-4 sm:py-2">Nombre</th>

                            <th class="hidden md:table-cell px-2 py-1 sm:px-4 sm:py-2">Correo</th>

                            <th class="hidden sm:table-cell px-2 py-1 sm:px-4 sm:py-2">Foto</th>

                            <th class="px-2 py-1 sm:px-4 sm:py-2">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($barbers as $barber)
                            <tr>
                                <td class="text-center px-2 py-1 sm:px-4 sm:py-2">{{ $barber->name }}</td>

                                <td class="hidden md:table-cell text-center px-2 py-1 sm:px-4 sm:py-2">
                                    {{ $barber->email }}</td>

                                <td class="hidden sm:table-cell px-2 py-1 sm:px-4 sm:py-2 text-center">
                                    <img src="{{ asset('storage/' . ($barber->photo ?? 'barbers/default.webp')) }}"
                                        alt="Foto de {{ $barber->name }}"
                                        class="w-12 h-12 object-cover rounded-full inline-block">
                                </td>

                                <td class="px-2 py-1 sm:px-4 sm:py-2 text-center space-x-2">
                                    <x-primary-button>
                                        <a href="{{ route('barbers.edit', $barber->id) }}">Editar</a>
                                    </x-primary-button>

                                    <form action="{{ route('barbers.destroy', $barber->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <x-danger-button
                                            onclick="return confirm('¿Seguro que deseas eliminar este barbero?')">
                                            Eliminar
                                        </x-danger-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</x-app-layout>
