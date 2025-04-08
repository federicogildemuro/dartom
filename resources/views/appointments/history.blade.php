<x-app-layout>
    <section class="min-h-screen p-5">
        <!-- If there are no appointments in history -->
        @if ($appointments->isEmpty())
            <p class="text-4xl font-bold text-yellow text-center mb-5">No tenés turnos en tu historial</p>
            <p class="text-lg text-center mb-5">Para sacar uno, clickeá en el botón de abajo</p>
            <div class="flex justify-center mb-5">
                <x-primary-button
                    class="bg-yellow text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-150 ease-in-out">
                    <a href="{{ route('appointments.available') }}">Sacar un turno</a>
                    <i class="fas fa-calendar-alt ms-2" aria-hidden="true"></i>
                </x-primary-button>
            </div>
        @else
            <!-- Appointments history table -->
            <h1 class="text-4xl font-bold text-yellow text-center mb-5">Historial</h1>
            <p class="text-lg text-center mb-5">Acá podés ver todos tus turnos pasados y futuros</p>
            <div class="overflow-x-auto">
                <table class="w-full sm:w-1/2 mx-auto mb-5">
                    <thead class="text-yellow">
                        <tr>
                            <th scope="col" class="px-4 py-2">Barbero</th>

                            <th scope="col" class="px-4 py-2">Fecha</th>

                            <th scope="col" class="px-4 py-2">Hora</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td class="px-4 py-2 text-center">
                                    {{ $appointment->barber->name }}
                                </td>

                                <td class="px-4 py-2 text-center">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}
                                </td>

                                <td class="px-4 py-2 text-center">
                                    {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="text-yellow mb-5">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
