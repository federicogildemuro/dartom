<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 xl:w-1/3 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">¿Te olvidaste tu contraseña?</h1>

        <p class="text-center mb-5">
            Tranqui, ingresá tu correo electrónico y te mandamos un enlace para restablecerla.
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" role="status" />

        <form method="POST" action="{{ route('password.email') }}" class="w-full" role="form">
            @csrf

            <!-- Email  -->
            <div class="mb-5">
                <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" aria-describedby="email-error" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" role="alert" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <x-primary-button>Enviar enlace de restablecimiento</x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
