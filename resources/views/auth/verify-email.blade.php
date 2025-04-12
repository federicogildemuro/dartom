<x-app-layout>
    <section class="flex flex-col items-center justify-start min-h-screen w-full sm:w-2/3 xl:w-1/3 mx-auto p-5">
        <h1 class="text-4xl font-bold text-yellow text-center mb-5">Todavía falta un paso más...</h1>

        <p class="text-center mb-5">
            Gracias por registrarte en nuestra página. Para que puedas utilizarla es necesario que verifiques tu correo
            electrónico, haciendo click en el enlace que te mandamos al registrarte.
        </p>

        <p class="text-center mb-5">
            Si no lo encontrás, revisá tu carpeta de spam o correo no deseado.
        </p>

        <p class="text-center mb-5">
            Si no recibiste el correo, podés pedir que te lo mandemos nuevamente haciendo click en el botón de
            abajo.
        </p>

        <!-- Session Status -->
        @if (session('status') == 'verification-link-sent')
            <div class="text-yellow mb-5" role="status" aria-live="polite">
                Ya te mandamos un nuevo enlace de verificación a tu correo electrónico.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}" class="w-100" role="form"
                aria-label="Reenviar enlace de verificación por correo electrónico">
                @csrf

                <!-- Submit Button -->
                <div class="flex items-center justify-center">
                    <x-primary-button>Reenviar enlace de verificación</x-primary-button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
