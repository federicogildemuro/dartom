<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 lg:w-1/2 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Antes de continuar...</h1>

        <p class="text-center mb-5">
            Como estás a punto de entrar a una sección restringida de la aplicación, necesitamos que confirmes tu
            contraseña.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="w-full" role="form">
            @csrf

            <!-- Password -->
            <div class="mb-5">
                <x-text-input id="password" class="block w-full" type="password" name="password" required
                    autocomplete="current-password" aria-describedby="password-error" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" role="alert" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <x-primary-button>Confirmar contraseña</x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
