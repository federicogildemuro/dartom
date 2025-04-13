<x-app-layout>
    <section class="min-h-screen p-5" x-data="{ barberId: null, showDeleteModal: false }">
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
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($barbers as $barber)
                            <tr>
                                <td class="text-center px-2 py-1 sm:px-4 sm:py-2">{{ $barber->name }}</td>

                                <td class="hidden md:table-cell text-center px-2 py-1 sm:px-4 sm:py-2">
                                    {{ $barber->email }}
                                </td>

                                <td class="hidden sm:table-cell px-2 py-1 sm:px-4 sm:py-2 text-center">
                                    <img src="{{ asset('storage/' . ($barber->photo ?? 'barbers/default.webp')) }}"
                                        alt="Foto de {{ $barber->name }}"
                                        class="w-12 h-12 object-cover rounded-full inline-block">
                                </td>

                                <td class="px-2 py-1 sm:px-4 sm:py-2 text-center space-x-2">
                                    <x-primary-button>
                                        <a href="{{ route('barbers.edit', $barber->id) }}">Editar</a>
                                    </x-primary-button>

                                    <x-danger-button
                                        @click.prevent="barberId = {{ $barber->id }}; showDeleteModal = true">
                                        Eliminar
                                    </x-danger-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Delete Barber Modal -->
                <div x-show="showDeleteModal" x-transition x-cloak
                    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
                    <div class="bg-black p-5 border-2 border-yellow rounded-lg shadow-lg max-w-sm w-full">
                        <h2 class="text-lg text-yellow font-bold mb-5 text-center">
                            ¿Estás seguro de que querés eliminar el barbero?
                        </h2>
                        <p class="mb-5 text-center">Esta acción no se puede deshacer.</p>

                        <div class="flex justify-between">
                            <x-primary-button @click="showDeleteModal = false">
                                Cancelar
                            </x-primary-button>

                            <form :action="`/barbers/${barberId}`" method="POST" @submit="showDeleteModal = false">
                                @csrf
                                @method('DELETE')

                                <x-danger-button type="submit">
                                    Eliminar
                                </x-danger-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-app-layout>
