<x-app-layout>
    <section class="min-h-screen p-5" x-data="{ barber: '', date: '', appointmentId: null, showModal: false, modalAction: '' }">

        <!-- Show success or error message -->
        @if (session('success'))
            <div role="alert" aria-live="polite"
                class="bg-green-100 text-green-800 border-l-4 border-green-500 p-4 mb-4">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div role="alert" aria-live="polite" class="bg-red-100 text-red-800 border-l-4 border-red-500 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Show existing appointment if it exists, otherwise show the filters and available appointments -->
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
                    <x-danger-button
                        @click.prevent="
                            showModal = true;
                            modalAction = 'cancel';
                            appointmentId = {{ $existingAppointment->id }};
                        "
                        aria-label="Cancelar turno con {{ $existingAppointment->barber->name }} el {{ $existingAppointment->date }}">
                        Cancelar Turno
                    </x-danger-button>
                </div>
            </div>
        @else
            <div class="flex flex-col md:flex-row items-center justify-center gap-5 mb-5" role="region"
                aria-labelledby="filtros">
                <h2 id="filtros" class="sr-only">Filtros disponibles</h2>

                <!-- Barber Filter -->
                <label for="barber-select" class="sr-only">Seleccionar Barbero</label>
                <select id="barber-select" x-model="barber"
                    @change="window.location.href = `{{ route('appointments.available') }}?barber_id=${barber}`"
                    class="text-black py-2 px-4 rounded border-2 border-yellow w-2/3 md:w-1/4"
                    aria-label="Seleccionar Barbero">
                    <option value="">Filtrar por Barbero</option>
                    @foreach ($barbers as $barberItem)
                        <option value="{{ $barberItem->id }}" @if (request('barber_id') == $barberItem->id) selected @endif>
                            {{ $barberItem->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Date Filter -->
                <label for="date-select" class="sr-only">Seleccionar Fecha</label>
                <input id="date-select" x-model="date" type="date"
                    @change="window.location.href = `{{ route('appointments.available') }}?date=${date}`"
                    class="text-black py-2 px-4 rounded border-2 border-yellow w-2/3 md:w-1/4"
                    value="{{ request('date') }}" aria-label="Seleccionar Fecha">
            </div>

            <!-- Show filters applied and clear button -->
            <div class="flex flex-col items-center justify-center mb-5">
                @if (request('barber_id'))
                    <span class="text-yellow mb-5">Mostrando turnos del barbero:
                        {{ $barbers->firstWhere('id', request('barber_id'))->name }}</span>
                @endif
                @if (request('date'))
                    <span class="text-yellow mb-5">Mostrando turnos del día:
                        {{ \Carbon\Carbon::parse(request('date'))->format('d-m-Y') }}</span>
                @endif
                @if (request('barber_id') || request('date'))
                    <form action="{{ route('appointments.available') }}" method="GET">
                        <x-primary-button aria-label="Limpiar filtros aplicados">Limpiar filtros</x-primary-button>
                    </form>
                @endif
            </div>

            <!-- If there are no available appointments show a message, otherwise show the table -->
            @if ($availableAppointments->isEmpty())
                <p class="text-4xl font-bold text-yellow text-center mb-5">No hay turnos disponibles para mostrar.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="text-sm sm:text-base w-full mb-5">
                        <caption class="sr-only">Lista de turnos disponibles para reservar</caption>
                        <thead class="text-yellow">
                            <tr>
                                <th class="text-start px-2 py-1 sm:px-4 sm:py-2">
                                    <a
                                        href="{{ route('appointments.available', ['sort' => 'barber_id', 'direction' => $sortColumn == 'barber_id' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        Barbero
                                        @if ($sortColumn == 'barber_id')
                                            <span>{{ $sortDirection == 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>

                                <th class="px-2 py-1 sm:px-4 sm:py-2">
                                    <a
                                        href="{{ route('appointments.available', ['sort' => 'date', 'direction' => $sortColumn == 'date' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        Fecha
                                        @if ($sortColumn == 'date')
                                            <span>{{ $sortDirection == 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>

                                <th class="px-2 py-1 sm:px-4 sm:py-2">Hora</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($availableAppointments as $appointment)
                                <tr>
                                    <td class="px-2 py-1 sm:px-4 sm:py-2">{{ $appointment->barber->name }}</td>

                                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">
                                        {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}
                                    </td>

                                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-center">
                                        {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                    </td>

                                    <td class="px-2 py-1 sm:px-4 sm:py-2 text-end">
                                        <x-primary-button
                                            @click.prevent="
                                                showModal = true;
                                                modalAction = 'book';
                                                appointmentId = {{ $appointment->id }};
                                            "
                                            aria-label="Reservar turno con {{ $appointment->barber->name }} el {{ $appointment->date }} a las {{ $appointment->time }}">
                                            Reservar
                                        </x-primary-button>
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

        <!-- Confirm Action Modal (Cancel / Book) -->
        <div x-show="showModal" x-transition x-cloak
            class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-black p-5 border-2 border-yellow rounded-lg shadow-lg max-w-sm w-full">
                <template x-if="modalAction === 'cancel' || modalAction === 'book'">
                    <h2 class="text-lg text-yellow text-center mb-5">
                        <span
                            x-text="modalAction === 'cancel' ? '¿Estás seguro de que querés cancelar el turno?' : '¿Estás seguro de que querés reservar el turno?'"></span>
                    </h2>
                </template>

                <div class="flex justify-between">
                    <template x-if="modalAction === 'cancel'">
                        <x-primary-button @click="showModal = false">
                            No, me lo quedo
                        </x-primary-button>
                    </template>

                    <template x-if="modalAction === 'book'">
                        <x-danger-button @click="showModal = false">
                            No, no lo quiero
                        </x-danger-button>
                    </template>

                    <template x-if="modalAction === 'cancel'">
                        <form :action="`/appointments/cancel`" method="POST" @submit="showModal = false">
                            @csrf
                            <input type="hidden" name="appointment_id" :value="appointmentId">
                            <x-danger-button type="submit">
                                Sí, no lo quiero
                            </x-danger-button>
                        </form>
                    </template>

                    <template x-if="modalAction === 'book'">
                        <form :action="`/appointments/book/${appointmentId}`" method="POST"
                            @submit="showModal = false">
                            @csrf
                            <x-primary-button type="submit">
                                Sí, me lo quedo
                            </x-primary-button>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
