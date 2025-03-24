<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-semibold">Editar Turno</h1>
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

        <!-- Update Appointment Form -->
        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            @csrf
            @method('PUT')

            <!-- Barber Select -->
            <div class="mb-4">
                <label for="barber_id" class="block font-semibold mb-1">Barbero</label>
                <select id="barber_id" name="barber_id"
                    class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
                    <option value="">Seleccione un barbero</option>
                    @foreach ($barbers as $barber)
                        <option value="{{ $barber->id }}" @if ($appointment->barber_id == $barber->id) selected @endif>
                            {{ $barber->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date Picker -->
            <div class="mb-4">
                <label for="date" class="block font-semibold mb-1">Fecha</label>
                <input type="date" id="date" name="date" value="{{ old('date', $appointment->date) }}"
                    class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
            </div>

            <!-- Time Picker -->
            <div class="mb-4">
                <label for="time" class="block font-semibold mb-1">Hora</label>
                <input type="time" id="time" name="time"
                    value="{{ old('time', \Carbon\Carbon::parse($appointment->time)->format('H:i')) }}"
                    class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-2">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-400">Guardar
                    Cambios</button>
                <a href="{{ route('appointments.index') }}"
                    class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-400">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
