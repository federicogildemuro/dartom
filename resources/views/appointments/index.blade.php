<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-semibold">Lista de Turnos</h1>
    </x-slot>

    <div class="container mx-auto p-5" x-data="{ barber: '', user: '', date: '' }">
        <!-- Show success message -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border-l-4 border-green-500 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Link to generate new appointments -->
        <a href="{{ route('appointments.create') }}"
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-400 mb-5 inline-block">
            Generar Turnos
        </a>

        <!-- Filters -->
        <div class="mb-4">
            <!-- Barber Filter -->
            <select x-model="barber"
                @change="window.location.href = `{{ route('appointments.index') }}?barber_id=${barber}`"
                class="bg-gray-200 border py-2 px-4 rounded">
                <option value="">Filtrar por Barbero</option>
                @foreach ($barbers as $barberItem)
                    <option value="{{ $barberItem->id }}" @if (request('barber_id') == $barberItem->id) selected @endif>
                        {{ $barberItem->name }}
                    </option>
                @endforeach
            </select>

            <!-- User Filter -->
            <select x-model="user" @change="window.location.href = `{{ route('appointments.index') }}?user_id=${user}`"
                class="bg-gray-200 border py-2 px-4 rounded">
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
                class="bg-gray-200 border py-2 px-4 rounded" value="{{ request('date') }}">
        </div>

        <!-- Show filters applied -->
        <div class="mb-4">
            @if (request('barber_id'))
                <span>Mostrando turnos del barbero: {{ $barbers->firstWhere('id', request('barber_id'))->name }}</span>
            @endif
            @if (request('user_id'))
                <span>Mostrando turnos del cliente: {{ $users->firstWhere('id', request('user_id'))->name }}</span>
            @endif
            @if (request('date'))
                <span>Mostrando turnos del día: {{ \Carbon\Carbon::parse(request('date'))->format('d-m-Y') }}</span>
            @endif
            </p>
        </div>

        <!-- Clear filters button -->
        @if (request('barber_id') || request('user_id') || request('date'))
            <form action="{{ route('appointments.index') }}" method="GET" class="mb-4">
                <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-400 inline-block">
                    Limpiar filtros
                </button>
            </form>
        @endif

        <!-- Show or hide appointments from previous days -->
        <div x-data="{ showAll: {{ request('show_all', 0) }} }">
            <!-- Button to show appointments from previous days -->
            <template x-if="!showAll">
                <button type="button"
                    class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-400 inline-block mb-4"
                    @click="window.location.href = `{{ route('appointments.index') }}?show_all=1`">
                    Mostrar turnos pasados
                </button>
            </template>

            <!-- Button to hide appointments from previous days -->
            <template x-if="showAll">
                <button type="button"
                    class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-400 inline-block mb-4"
                    @click="window.location.href = `{{ route('appointments.index') }}?show_all=0`">
                    Ocultar turnos pasados
                </button>
            </template>
        </div>

        <!-- If there are no appointments to show, display a message -->
        <!-- Otherwise, show the appointments in a table -->
        @if ($appointments->isEmpty())
            <p class="text-lg">No hay turnos para mostrar.</p>
        @else
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-start">
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

                        <th class="px-4 py-2 border-b text-start">
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

                        <th class="px-4 py-2 border-b">
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

                        <th class="px-4 py-2 border-b">Hora</th>

                        <th class="px-4 py-2 border-b">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b">
                                {{ $appointment->barber->name }}
                            </td>

                            <td class="px-4 py-2 border-b">
                                {{ $appointment->user ? $appointment->user->name : 'No asignado' }}
                            </td>

                            <td class="px-4 py-2 border-b text-center">
                                {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}
                            </td>

                            <td class="px-4 py-2 border-b text-center">
                                {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                            </td>

                            <td class="px-4 py-2 border-b text-center space-x-2">
                                <a href="{{ route('appointments.edit', $appointment->id) }}"
                                    class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-400 inline-block">
                                    Editar
                                </a>

                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-400 inline-block"
                                        onclick="return confirm('¿Seguro que deseas eliminar este turno?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
