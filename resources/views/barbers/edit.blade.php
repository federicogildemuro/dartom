<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 lg:w-1/2 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Editar Barbero</h1>
        <p class="text-center mb-5">Acá podés editar la información de un barbero existente.</p>

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

        <!-- Edit Barber Form -->
        <form method="POST" enctype="multipart/form-data" action="{{ route('barbers.update', $barber->id) }}"
            class="w-full">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-5">
                <x-input-label for="name" :value="'Nombre'" />
                <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name', $barber->name)"
                    required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="'Correo electrónico'" />
                <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email', $barber->email)"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Photo -->
            <div class="mb-5">
                <x-input-label for="photo" :value="'Foto (opcional)'" />
                <input id="photo" class="block mt-2 w-full" type="file" name="photo" :value="old('photo')" />
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                @if ($barber->photo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $barber->photo) }}" alt="Foto del barbero"
                            class="w-24 h-24 object-cover rounded-full border">
                    </div>
                @endif
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-5 mb-5">
                <!-- Cancel Button -->
                <x-danger-button>
                    <a href="{{ route('barbers.index') }}">Cancelar</a>
                </x-danger-button>

                <!-- Submit Button -->
                <x-primary-button>Guardar</x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
