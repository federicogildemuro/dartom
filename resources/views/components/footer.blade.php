<footer class="grid grid-cols-1 sm:grid-cols-3 gap-10 sm:gap-5 bg-gray p-10 text-xl" role="contentinfo">
    <!-- Navigation Links -->
    <nav class="flex flex-col gap-5 text-center sm:text-start" aria-label="Secciones del sitio">
        <x-footer-link :href="route('home') . '#home'">Inicio</x-footer-link>

        <x-footer-link :href="route('home') . '#about'">Nosotros</x-footer-link>

        <x-footer-link :href="route('home') . '#contact'">Contacto</x-footer-link>
    </nav>

    <!-- Social Media Links -->
    <nav class="flex flex-col gap-5 text-center" aria-label="Redes sociales">
        <h2 class="text-2xl">Seguinos en nuestras redes</h2>

        <ul class="flex justify-center gap-5" role="list">
            <li>
                <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="TikTok">
                    <i class="fab fa-tiktok text-2xl" aria-hidden="true"></i>
                    <span class="sr-only">TikTok</span>
                </x-footer-link>
            </li>

            <li>
                <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="Instagram">
                    <i class="fab fa-instagram text-2xl" aria-hidden="true"></i>
                    <span class="sr-only">Instagram</span>
                </x-footer-link>
            </li>

            <li>
                <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="Facebook">
                    <i class="fab fa-facebook text-2xl" aria-hidden="true"></i>
                    <span class="sr-only">Facebook</span>
                </x-footer-link>
            </li>

            <li>
                <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="Twitter (X)">
                    <i class="fab fa-x-twitter text-2xl" aria-hidden="true"></i>
                    <span class="sr-only">Twitter</span>
                </x-footer-link>
            </li>

            <li>
                <x-footer-link href="#" target="_blank" rel="noopener noreferrer" ariaLabel="YouTube">
                    <i class="fab fa-youtube text-2xl" aria-hidden="true"></i>
                    <span class="sr-only">YouTube</span>
                </x-footer-link>
            </li>
        </ul>
    </nav>

    <!-- Developer's Portfolio Link -->
    <div class="flex flex-col gap-5 text-center sm:text-end">
        <x-footer-link href="https://federico-gil-de-muro-portfolio.vercel.app/" target="_blank"
            rel="noopener noreferrer" ariaLabel="Visitar el portfolio de Federico Gil de Muro">
            <i class="fas fa-code" aria-hidden="true"></i>
            <span class="sr-only">Portfolio de</span> Federico Gil de Muro
        </x-footer-link>
    </div>
</footer>
