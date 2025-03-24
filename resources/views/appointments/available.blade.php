<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-semibold">
            @if (isset($existingAppointment))
                Tu turno actual
            @else
                Turnos disponibles
            @endif
        </h1>
    </x-slot>

    <div class="container mx-auto p-5" x-data="{ barber: '', date: '' }">
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

        <!-- Show user appointment details if exists -->
        @if (isset($existingAppointment))
            <div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto mb-6 text-center">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <p>
                            <strong>Barbero: </strong>
                            {{ $existingAppointment->barber->name }}
                        </p>
                    </div>

                    <div>
                        <p>
                            <strong>Día: </strong>
                            {{ \Carbon\Carbon::parse($existingAppointment->date)->format('d-m-Y') }}
                        </p>
                    </div>

                    <div>
                        <p>
                            <strong>Hora: </strong>
                            {{ \Carbon\Carbon::parse($existingAppointment->time)->format('H:i') }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('appointments.cancel') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-400 inline-block">
                        Cancelar Turno
                    </button>
                </form>
            </div>
        @else
            <!-- If the user has no current appointment, show available appointments -->
            <div class="mb-4">
                <!-- Barber Filter -->
                <select x-model="barber"
                    @change="window.location.href = `{{ route('appointments.available') }}?barber_id=${barber}`"
                    class="bg-gray-200 border py-2 px-4 rounded">
                    <option value="">Filtrar por Barbero</option>
                    @foreach ($barbers as $barberItem)
                        <option value="{{ $barberItem->id }}" @if (request('barber_id') == $barberItem->id) selected @endif>
                            {{ $barberItem->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Date Filter -->
                <input type="date" x-model="date"
                    @change="window.location.href = `{{ route('appointments.available') }}?date=${date}`"
                    class="bg-gray-200 border py-2 px-4 rounded" value="{{ request('date') }}">
            </div>

            <!-- Show filters applied -->
            <div class="mb-4">
                @if (request('barber_id'))
                    <span>Mostrando turnos del barbero:
                        {{ $barbers->firstWhere('id', request('barber_id'))->name }}</span>
                @endif
                @if (request('date'))
                    <span>Mostrando turnos del día:
                        {{ \Carbon\Carbon::parse(request('date'))->format('d-m-Y') }}</span>
                @endif
            </div>

            <!-- Clear filters button -->
            @if (request('barber_id') || request('date'))
                <form action="{{ route('appointments.available') }}" method="GET" class="mb-4">
                    <button type="submit"
                        class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-400 inline-block">
                        Limpiar filtros
                    </button>
                </form>
            @endif

            <!-- If no available appointments -->
            @if ($availableAppointments->isEmpty())
                <p class="text-lg">No hay turnos disponibles en este momento.</p>
            @else
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b text-start">
                                <a
                                    href="{{ route('appointments.available', ['sort' => 'barber_id', 'direction' => $sortColumn == 'barber_id' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
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

                            <th class="px-4 py-2 border-b text-center">
                                <a
                                    href="{{ route('appointments.available', ['sort' => 'date', 'direction' => $sortColumn == 'date' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
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

                            <th class="px-4 py-2 border-b text-center">Hora</th>

                            <th class="px-4 py-2 border-b">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($availableAppointments as $appointment)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border-b">{{ $appointment->barber->name }}</td>
                                <td class="px-4 py-2 border-b text-center">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}</td>
                                <td class="px-4 py-2 border-b text-center">
                                    {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                                <td class="px-4 py-2 border-b text-center">
                                    <form action="{{ route('appointments.book', $appointment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-400">
                                            Reservar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $availableAppointments->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
