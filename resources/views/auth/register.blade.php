<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 xl:w-1/3 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Registrarse</h1>

        <form method="POST" action="{{ route('register') }}" class="w-full" role="form">
            @csrf

            <!-- Name -->
            <div class="mb-5">
                <x-input-label for="name" :value="'Nombre'" />
                <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" aria-describedby="name-error" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" id="name-error" role="alert" />
            </div>

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="'Correo electrónico'" />
                <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" aria-describedby="email-error" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" role="alert" />
            </div>

            <!-- Phone -->
            <div class="mb-5">
                <x-input-label for="phone" :value="'Teléfono'" />
                <x-text-input id="phone" class="block mt-2 w-full" type="text" name="phone" :value="old('phone')"
                    required maxlength="15" autocomplete="tel" aria-describedby="phone-error" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" id="phone-error" role="alert" />
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
                    aria-describedby="password_confirmation-error" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" id="password_confirmation-error" role="alert" />
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-5 mb-5">
                <!-- Login Link -->
                <div class="text-center">
                    <a class="hover:text-yellow transition duration-150 ease-in-out" href="{{ route('login') }}">
                        ¿Ya tenés una cuenta?
                    </a>
                </div>

                <!-- Submit Button -->
                <x-primary-button>Registrarse</x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
