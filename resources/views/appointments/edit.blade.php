<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 lg:w-1/2 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Editar Turno</h1>
        <p class="text-center mb-5">Acá podés editar la información de un turno existente.</p>

        <!-- Show error messages -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 border-l-4 border-red-500 p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Update Appointment Form -->
        <form method="POST" action="{{ route('appointments.update', $appointment->id) }}" class="w-full">
            @csrf
            @method('PUT')

            <!-- Barber Select -->
            <div class="mb-5">
                <x-input-label for="barber_id" :value="'Barbero'" />
                <select id="barber_id" name="barber_id"
                    class="text-black mt-2 py-2 px-4 rounded border-2 border-yellow w-full" required>
                    <option value="">Seleccionar Barbero</option>
                    @foreach ($barbers as $barber)
                        <option value="{{ $barber->id }}" @if ($appointment->barber_id == $barber->id) selected @endif>
                            {{ $barber->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date Picker -->
            <div class="mb-5">
                <x-input-label for="date" :value="'Fecha'" />
                <input type="date" id="date" name="date"
                    value="{{ old('date', \Carbon\Carbon::parse($appointment->date)->format('Y-m-d')) }}"
                    class="text-black mt-2 py-2 px-4 rounded border-2 border-yellow w-full" required>
            </div>

            <!-- Time Picker -->
            <div class="mb-5">
                <x-input-label for="time" :value="'Hora'" />
                <input type="time" id="time" name="time"
                    value="{{ old('time', \Carbon\Carbon::parse($appointment->time)->format('H:i')) }}"
                    class="text-black mt-2 py-2 px-4 rounded border-2 border-yellow w-full" required>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-5 mb-5">
                <!-- Cancel Button -->
                <x-danger-button>
                    <a href="{{ route('appointments.index') }}">Cancelar</a>
                </x-danger-button>

                <!-- Submit Button -->
                <x-primary-button>Guardar</x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
