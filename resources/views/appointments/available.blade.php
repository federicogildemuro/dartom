<x-app-layout>
    <section class="min-h-screen p-5" x-data="{ barber: '', date: '' }">

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
            <h1 class="text-4xl font-bold text-yellow text-center mb-5">Tu próximo turno</h1>
            <p class="text-center mb-5">Solo podés tener un turno activo a la vez.</p>
            <p class="text-center mb-5">Si querés cambiarlo, primero tenés que cancelar el actual.</p>

            <div
                class="flex flex-col items-center justify-center gap-5 border-2 border-yellow rounded-lg shadow-yellow shadow-sm max-w-lg mx-auto p-5 mb-5">
                <div>
                    <p><strong>Barbero: </strong>{{ $existingAppointment->barber->name }}</p>
                </div>

                <div>
                    <p><strong>Día: </strong>{{ \Carbon\Carbon::parse($existingAppointment->date)->format('d-m-Y') }}
                    </p>
                </div>

                <div>
                    <p><strong>Hora: </strong>{{ \Carbon\Carbon::parse($existingAppointment->time)->format('H:i') }}</p>
                </div>

                <div>
                    <form action="{{ route('appointments.cancel') }}" method="POST">
                        @csrf
                        <x-danger-button>Cancelar Turno</x-danger-button>
                    </form>
                </div>
            </div>
        @else
            <!-- If the user has no current appointment, show filters and available appointments -->
            <div class="flex flex-col md:flex-row items-center justify-center gap-5 mb-5">
                <!-- Barber Filter -->
                <select x-model="barber"
                    @change="window.location.href = `{{ route('appointments.available') }}?barber_id=${barber}`"
                    class="text-black py-2 px-4 rounded border-2 border-yellow w-2/3 md:w-1/4">

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

            <!-- If no available appointments -->
            @if ($availableAppointments->isEmpty())
                <p class="text-4xl font-bold text-yellow text-center mb-5">No hay turnos disponibles para mostrar.</p>
            @else
                <!-- Available appointments Table -->
                <div class="overflow-x-auto">
                    <table class="text-sm sm:text-base w-full mb-5">
                        <thead class="text-yellow">
                            <tr>
                                <th class="text-start px-2 py-1 sm:px-4 sm:py-2">
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

                                <th class="px-2 py-1 sm:px-4 sm:py-2">
                                    <a
                                        href="{{ route('appointments.available', ['sort' => 'date', 'direction' => $sortColumn == 'date' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        Fecha
                                        @if ($sortColumn == 'date')
                                            @if ($sortDirection == 'asc')
                                                <i class="fas fa-arrow-up"></i>
                                            @else
                                                <i class="fas fa-arrow-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                </th>

                                <th class="px-2 py-1 sm:px-4 sm:py-2">Hora</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($availableAppointments as $appointment)
                                <tr>
                                    <td class="px-2 py-1 sm:px-4 sm:py-2">
                                        {{ $appointment->barber->name }}
                                    </td>

                                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">
                                        {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}
                                    </td>

                                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">
                                        {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                    </td>

                                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-end">
                                        <form action="{{ route('appointments.book', $appointment->id) }}"
                                            method="POST">
                                            @csrf
                                            <x-primary-button>Reservar</x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="text-yellow mb-5">
                    {{ $availableAppointments->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </section>
</x-app-layout>
