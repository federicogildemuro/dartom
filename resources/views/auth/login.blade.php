<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 xl:w-1/3 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Iniciar sesión</h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" role="status" />

        <form method="POST" action="{{ route('login') }}" class="w-full" role="form">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="'Correo electrónico'" />
                <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" aria-describedby="email-error" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" role="alert" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <x-input-label for="password" :value="'Contraseña'" />
                <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required
                    autocomplete="current-password" aria-describedby="password-error" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" role="alert" />
            </div>

            <!-- Remember Me -->
            <div class="block mb-5">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="border-2 border-gray rounded text-yellow"
                        name="remember" aria-describedby="remember-me-description">
                    <p id="remember-me-description" class="text-sm ms-2">Mantener la sesión iniciada</p>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center mb-5">
                <x-primary-button>Iniciar sesión</x-primary-button>
            </div>

            <!--Links-->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-5 mb-5">
                <!-- Forgot Password Link-->
                <div class="text-center">
                    <a class="hover:text-yellow transition duration-150 ease-in-out"
                        href="{{ route('password.request') }}">
                        ¿Te olvidaste la contraseña?
                    </a>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <a class="hover:text-yellow transition duration-150 ease-in-out" href="{{ route('register') }}">
                        ¿No tenés una cuenta?
                    </a>
                </div>
            </div>
        </form>
    </section>
</x-app-layout>
