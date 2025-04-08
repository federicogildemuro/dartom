<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 lg:w-1/2 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Mi Perfil</h1>

        <!-- Profile Information -->
        <h2 class="text-3xl text-yellow text-center mb-5">Información de la cuenta</h2>
        <p class="text-center mb-5">Actualizá tus datos personales y de contacto. Asegurate de que la información sea
            correcta para poder recibir notificaciones importantes.</p>
        <p class="text-center mb-5">Si cambias tu dirección de correo electrónico, se te enviará un enlace de
            verificación a la nueva dirección.</p>

        <!-- Session Status -->
        @if (session('status') == 'profile-updated')
            <p class="text-green-500 mb-5" role="status" aria-live="polite">
                Tu información de perfil ha sido actualizada correctamente.
            </p>
        @endif

        <!-- Email Verification Form -->
        <form id="send-verification" method="post" action="{{ route('verification.send') }}" aria-hidden="true">
            @csrf
        </form>

        <!-- Profile Update Form -->
        <form method="post" action="{{ route('profile.update') }}" class="w-full mb-10" role="form"
            aria-label="Formulario para actualizar información de perfil">
            @csrf
            @method('patch')

            <!-- Name -->
            <div class="mb-5">
                <x-input-label for="name" :value="'Nombre'" />
                <x-text-input id="name" name="name" type="text" class="mt-2 block w-full" :value="old('name', $user->name)"
                    required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="'Correo electrónico'" />
                <x-text-input id="email" name="email" type="email" class="mt-2 block w-full" :value="old('email', $user->email)"
                    required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                <!-- Email Verification -->
                @if (!$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm text-red-500 my-2">
                            Tu dirección de correo electrónico no está verificada.
                        </p>
                        <button form="send-verification"
                            class="text-sm hover:text-yellow transition duration-150 ease-in-out mb-2"
                            aria-label="Reenviar enlace de verificación de correo">
                            Hacé click acá y te enviamos un nuevo enlace para validarla.
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="text-sm text-green-500 mb-2" role="status" aria-live="polite">
                                Se te envió un nuevo enlace de verificación a tu correo electrónico.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Phone -->
            <div class="mb-5">
                <x-input-label for="phone" :value="'Teléfono'" />
                <x-text-input id="phone" name="phone" type="text" class="mt-2 block w-full" :value="old('phone', $user->phone)"
                    required maxlength="15" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <x-primary-button>Guardar</x-primary-button>
            </div>
        </form>

        <!-- Password -->
        <h2 class="text-3xl text-yellow text-center mb-5">Cambiar contraseña</h2>
        <p class="text-center mb-5">
            Modificá tu contraseña para mantener tu cuenta segura. Asegurate de usar una contraseña fuerte y única.
        </p>

        <!-- Session Status -->
        @if (session('status') == 'password-updated')
            <p class="text-green-500 mb-5" role="status" aria-live="polite">
                Tu contraseña ha sido actualizada correctamente.
            </p>
        @endif

        <!-- Password Update Form -->
        <form method="post" action="{{ route('password.update') }}" class="w-full mb-10" role="form"
            aria-label="Formulario para cambiar la contraseña">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div class="mb-5">
                <x-input-label for="update_password_current_password" :value="'Contraseña actual'" />
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                    class="mt-2 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div class="mb-5">
                <x-input-label for="update_password_password" :value="'Nueva contraseña'" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-5">
                <x-input-label for="update_password_password_confirmation" :value="'Confirmar nueva contraseña'" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="mt-2 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <x-primary-button>Guardar</x-primary-button>
            </div>
        </form>

        <!-- Delete Account -->
        <h2 class="text-3xl text-yellow text-center mb-5">Eliminar cuenta</h2>
        <p class="text-center mb-5">
            Si ya no necesitás tu cuenta, podés eliminarla. Tené en cuenta que esta acción es irreversible y eliminará
            permanentemente todos tus datos.
        </p>

        <!-- Submit Button -->
        <div class="flex items-center justify-center mb-10">
            <x-danger-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                aria-label="Abrir modal para confirmar eliminación de cuenta">Borrar cuenta</x-danger-button>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="w-full p-5" role="form"
                aria-label="Formulario para confirmar la eliminación de cuenta">
                @csrf
                @method('delete')

                <h2 class="text-2xl font-bold text-yellow text-center mb-5">
                    ¿Estás seguro de que querés eliminar tu cuenta?
                </h2>
                <p class="text-center mb-5">
                    Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente.
                    Ingresá tu contraseña para confirmar que querés eliminar tu cuenta de forma permanente.
                </p>

                <div class="mb-5">
                    <x-text-input id="password" name="password" type="password" class="mt-2 block w-full" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-5">
                    <x-primary-button x-on:click="$dispatch('close')">Cancelar</x-primary-button>
                    <x-danger-button>Borrar cuenta</x-danger-button>
                </div>
            </form>
        </x-modal>
    </section>
</x-app-layout>
