<x-app-layout>
    <section class="min-h-screen p-5" x-data="{
        barber: '',
        user: '',
        date: '',
        appointmentId: null,
        showDeleteModal: false
    }">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Turnos</h1>
        <p class="text-center mb-5">Acá podés ver y gestionar todos los turnos registrados.</p>

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

        <!-- Add Appointments Button -->
        <div class="flex flex-col items-center justify-center mb-5">
            <x-primary-button class="mb-5">
                <a href="{{ route('appointments.create') }}">Agregar turnos</a>
            </x-primary-button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row items-center justify-center gap-5 mb-5">
            <!-- Barber Filter -->
            <select x-model="barber"
                @change="window.location.href = `{{ route('appointments.index') }}?barber_id=${barber}`"
                class="text-black py-2 px-4 rounded border-2 border-yellow w-2/3 md:w-1/4">

                <option value="">Filtrar por Barbero</option>

                @foreach ($barbers as $barberItem)
                    <option value="{{ $barberItem->id }}" @if (request('barber_id') == $barberItem->id) selected @endif>
                        {{ $barberItem->name }}
                    </option>
                @endforeach
            </select>

            <!-- User Filter -->
            <select x-model="user" @change="window.location.href = `{{ route('appointments.index') }}?user_id=${user}`"
                class="text-black py-2 px-4 rounded border-2 border-yellow w-2/3 md:w-1/4">

                <option value="">Filtrar por Cliente</option>

                @foreach ($users as $userItem)
                    <option value="{{ $userItem->id }}" @if (request('user_id') == $userItem->id) selected @endif>
                        {{ $userItem->name }}
                    </option>
                @endforeach
            </select>

            <!-- Date Filter -->
            <input type="date" x-model="date"
                @change="window.location.href = `{{ route('appointments.index') }}?date=${date}`"
                class="text-black py-2 px-4 rounded border-2 border-yellow w-2/3 md:w-1/4"
                value="{{ request('date') }}">
        </div>

        <!-- Show filters applied -->
        <div class="flex flex-col items-center justify-center mb-5">
            <!-- Show selected barber -->
            @if (request('barber_id'))
                <span class="text-yellow mb-5">
                    Mostrando turnos del barbero:{{ $barbers->firstWhere('id', request('barber_id'))->name }}
                </span>
            @endif

            <!-- Show selected user -->
            @if (request('user_id'))
                <span class="text-yellow mb-5">
                    Mostrando turnos del cliente:{{ $users->firstWhere('id', request('user_id'))->name }}
                </span>
            @endif

            <!-- Show selected date -->
            @if (request('date'))
                <span class="text-yellow mb-5">
                    Mostrando turnos del día:{{ \Carbon\Carbon::parse(request('date'))->format('d-m-Y') }}
                </span>
            @endif

            <!-- Clear filters button -->
            @if (request('barber_id') || request('date'))
                <form action="{{ route('appointments.available') }}" method="GET">
                    <x-primary-button>Limpiar filtros</x-primary-button>
                </form>
            @endif
        </div>

        <!-- Show or hide appointments from previous days -->
        <div x-data="{ showAll: {{ request('show_all', 0) }} }" class="flex flex-col items-center justify-center mb-5">
            <!-- Button to show appointments from previous days -->
            <template x-if="!showAll">
                <x-primary-button @click="window.location.href = `{{ route('appointments.index') }}?show_all=1`">
                    Mostrar turnos pasados
                </x-primary-button>
            </template>

            <!-- Button to hide appointments from previous days -->
            <template x-if="showAll">
                <x-danger-button @click="window.location.href = `{{ route('appointments.index') }}?show_all=0`">
                    Ocultar turnos pasados
                </x-danger-button>
            </template>
        </div>

        <!-- If there are no appointments, show a message, otherwise show the list -->
        @if ($appointments->isEmpty())
            <p class="text-4xl font-bold text-yellow text-center mb-5">No hay turnos registrados</p>
        @else
            <div class="overflow-x-auto">
                <table class="text-xs sm:text-sm md:text-base w-full mb-5">
                    <thead class="text-yellow">
                        <tr>
                            <th class="px-2 py-1 sm:px-4 sm:py-2 whitespace-nowrap">
                                <a
                                    href="{{ route('appointments.index', ['sort' => 'barber_id', 'direction' => $sortColumn == 'barber_id' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                    Barbero
                                    @if ($sortColumn == 'barber_id')
                                        @if ($sortDirection == 'asc')
                                            <span>▲</span>
                                        @else
                                            <span>▼</span>
                                        @endif
                                    @endif
                                </a>
                            </th>

                            <th class="hidden sm:table-cell px-2 py-1 sm:px-4 sm:py-2 whitespace-nowrap">
                                <a
                                    href="{{ route('appointments.index', ['sort' => 'user_id', 'direction' => $sortColumn == 'user_id' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                    Cliente
                                    @if ($sortColumn == 'user_id')
                                        @if ($sortDirection == 'asc')
                                            <span>▲</span>
                                        @else
                                            <span>▼</span>
                                        @endif
                                    @endif
                                </a>
                            </th>

                            <th class="px-2 py-1 sm:px-4 sm:py-2 whitespace-nowrap">
                                <a
                                    href="{{ route('appointments.index', ['sort' => 'date', 'direction' => $sortColumn == 'date' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                    Fecha
                                    @if ($sortColumn == 'date')
                                        @if ($sortDirection == 'asc')
                                            <span>▲</span>
                                        @else
                                            <span>▼</span>
                                        @endif
                                    @endif
                                </a>
                            </th>

                            <th class="px-2 py-1 sm:px-4 sm:py-2 whitespace-nowrap">Hora</th>

                            <th class="px-2 py-1 sm:px-4 sm:py-2 whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td class="text-center px-2 py-1 sm:px-4 sm:py-2 whitespace-nowrap">
                                    {{ $appointment->barber->name ?? 'No asignado' }}
                                </td>

                                <td
                                    class="hidden sm:table-cell text-center px-2 py-1 sm:px-4 sm:py-2 whitespace-nowrap">
                                    {{ $appointment->user->name ?? 'No asignado' }}
                                </td>

                                <td class="px-2 py-1 sm:px-4 sm:py-2 text-center whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}
                                </td>

                                <td class="px-2 py-1 sm:px-4 sm:py-2 text-center whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                </td>

                                <td class="px-2 py-1 sm:px-4 sm:py-2 text-center flex justify-center gap-2">
                                    <x-primary-button>
                                        <a href="{{ route('appointments.edit', $appointment->id) }}">Editar</a>
                                    </x-primary-button>

                                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <x-danger-button
                                            @click.prevent="appointmentId = {{ $appointment->id }}; showDeleteModal = true">
                                            Eliminar
                                        </x-danger-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Delete Appointment Modal -->
                <div x-show="showDeleteModal" x-transition x-cloak
                    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
                    <div class="bg-black p-5 border-2 border-yellow rounded-lg shadow-lg max-w-sm w-full">
                        <h2 class="text-lg text-yellow font-bold mb-5 text-center">
                            ¿Estás seguro de que deseas eliminar el turno?
                        </h2>
                        <p class="mb-5 text-center">Esta acción no se puede deshacer.</p>

                        <div class="flex justify-between">
                            <x-primary-button @click="showDeleteModal = false">
                                Cancelar
                            </x-primary-button>

                            <form :action="`/appointments/${appointmentId}`" method="POST"
                                @submit="showDeleteModal = false">
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

            <!-- Pagination -->
            <div class="mt-4">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
