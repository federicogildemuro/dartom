<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 lg:w-1/2 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Agregar Turnos</h1>
        <p class="text-center mb-5">Acá podés agregar nuevos turnos al sistema.</p>

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

        <!-- Add Appointments form -->
        <form method="POST" action="{{ route('appointments.store') }}" class="w-full">
            @csrf

            <!-- Barber Select -->
            <div class="mb-5">
                <x-input-label for="barber_id" :value="'Barbero'" />
                <select id="barber_id" name="barber_id"
                    class="text-black mt-2 py-2 px-4 rounded border-2 border-yellow w-full" required>
                    <option value="">Seleccionar Barbero</option>
                    @foreach ($barbers as $barber)
                        <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Picker -->
            <div class="mb-5">
                <x-input-label for="date" :value="'Fecha'" />
                <input type="date" id="date" name="date"
                    class="text-black mt-2 py-2 px-4 rounded border-2 border-yellow w-full" required>
            </div>

            <!-- Start Time -->
            <div class="mb-5">
                <x-input-label for="start_time" :value="'Hora de inicio'" />
                <input type="time" id="start_time" name="start_time"
                    class="text-black mt-2 py-2 px-4 rounded border-2 border-yellow w-full" required>
            </div>

            <!-- End Time -->
            <div class="mb-5">
                <x-input-label for="end_time" :value="'Hora de fin'" />
                <input type="time" id="end_time" name="end_time"
                    class="text-black mt-2 py-2 px-4 rounded border-2 border-yellow w-full" required>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-5 mb-5">
                <!-- Cancel Button -->
                <x-danger-button>
                    <a href="{{ route('appointments.index') }}">Cancelar</a>
                </x-danger-button>

                <!-- Submit Button -->
                <x-primary-button>Generar turnos</x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
