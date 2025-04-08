<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 lg:w-1/2 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Ingresá tu nueva contraseña</h1>

        <form method="POST" action="{{ route('password.store') }}" class="w-full" role="form">
            @csrf

            <!-- Password Reset Token (hidden) -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="'Correo electrónico'" />
                <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email', $request->email)"
                    required autofocus autocomplete="username" aria-describedby="email-error" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" role="alert" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <x-input-label for="password" :value="'Contraseña'" />
                <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required
                    autocomplete="new-password" aria-describedby="password-error" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" role="alert" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-5">
                <x-input-label for="password_confirmation" :value="'Confirmar contraseña'" />
                <x-text-input id="password_confirmation" class="block mt-2 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password"
                    aria-describedby="password-confirmation-error" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" id="password-confirmation-error" role="alert" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <x-primary-button>Restablecer contraseña</x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
