<footer class="grid grid-cols-1 sm:grid-cols-3 gap-10 sm:gap-5 bg-gray p-10 text-xl">
    <!-- Navigation Links -->
    <nav class="flex flex-col gap-5 text-center sm:text-start" aria-label="Enlaces de navegación">
        <x-footer-link href="{{ route('home') }}">Inicio</x-footer-link>

        <x-footer-link href="#about">Nosotros</x-footer-link>

        <x-footer-link href="#contact">Contacto</x-footer-link>
    </nav>

    <!-- Social Media Links -->
    <nav class="flex flex-col gap-5 text-center">
        <h2 class="text-2xl">Seguinos en nuestras redes</h2>

        <div class="flex justify-center gap-5" aria-label="Redes sociales">
            <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="TikTok">
                <i class="fab fa-tiktok text-2xl"></i>
            </x-footer-link>

            <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="Instagram">
                <i class="fab fa-instagram text-2xl"></i>
            </x-footer-link>

            <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="Facebook">
                <i class="fab fa-facebook text-2xl"></i>
            </x-footer-link>

            <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="Twitter">
                <i class="fab fa-x-twitter text-2xl"></i>
            </x-footer-link>

            <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="YouTube">
                <i class="fab fa-youtube text-2xl"></i>
            </x-footer-link>
        </div>
    </nav>

    <!-- Developer's Portfolio Link -->
    <div class="flex flex-col gap-5 text-center sm:text-end">
        <x-footer-link href="https://federico-gil-de-muro-portfolio.vercel.app/" target="_blank"
            rel="noopener noreferrer" ariaLabel="Portfolio de Federico Gil de Muro">
            <i class="fas fa-code"></i>
            Federico Gil de Muro
        </x-footer-link>
    </div>
</footer>
