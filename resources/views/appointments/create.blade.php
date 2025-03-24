<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-semibold">Generar Turnos</h1>
    </x-slot>

    <div class="container mx-auto p-5">
        <!-- Show errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 border-l-4 border-red-500 p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create Appointment Form -->
        <form action="{{ route('appointments.store') }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            @csrf
            <div class="grid grid-cols-1 gap-4 mb-4">
                <!-- Barber Select -->
                <div>
                    <label for="barber_id" class="block font-semibold mb-1">Barbero</label>
                    <select id="barber_id" name="barber_id"
                        class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
                        <option value="">Seleccionar Barbero</option>
                        @foreach ($barbers as $barber)
                            <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Picker -->
                <div>
                    <label for="date" class="block font-semibold mb-1">Fecha</label>
                    <input type="date" id="date" name="date"
                        class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
                </div>

                <!-- Start Time -->
                <div>
                    <label for="start_time" class="block font-semibold mb-1">Hora de inicio</label>
                    <input type="time" id="start_time" name="start_time"
                        class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
                </div>

                <!-- End Time -->
                <div>
                    <label for="end_time" class="block font-semibold mb-1">Hora de fin</label>
                    <input type="time" id="end_time" name="end_time"
                        class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-2 mt-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-400">
                    Generar Turnos
                </button>

                <a href="{{ route('appointments.index') }}"
                    class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
