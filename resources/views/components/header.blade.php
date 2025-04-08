<header x-data="{ open: false }" class="px-5 sm:px-10" role="banner">
    <nav class="flex justify-between items-center" aria-label="Navegación principal">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="hover:scale-110 transition duration-150 ease-in-out">
            <img src="{{ asset('storage/logo.webp') }}" alt="Logo de Dartom Barbería" class="h-32 object-contain">
        </a>

        <!-- Navigation Links -->
        <div class="hidden sm:inline-flex gap-10 items-center">
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Inicio</x-nav-link>
            <x-nav-link :href="'#about'" :active="request()->routeIs('about')">Nosotros</x-nav-link>
            <x-nav-link :href="'#contact'" :active="request()->routeIs('contact')">Contacto</x-nav-link>

            @auth
                @if (Auth::user()->role == 'user')
                    <x-nav-link :href="route('appointments.available')" :active="request()->routeIs('appointments.available')" title="Turnos">
                        <i class="fas fa-calendar-alt" aria-hidden="true"></i><span class="sr-only">Turnos</span>
                    </x-nav-link>
                    <x-nav-link :href="route('appointments.history')" :active="request()->routeIs('appointments.history')" title="Historial">
                        <i class="fas fa-history" aria-hidden="true"></i><span class="sr-only">Historial</span>
                    </x-nav-link>
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" title="Perfil">
                        <i class="fas fa-user" aria-hidden="true"></i><span class="sr-only">Perfil</span>
                    </x-nav-link>
                @endif

                @if (Auth::user()->role == 'admin')
                    <x-nav-link :href="route('barbers.index')" :active="request()->routeIs('barbers.index')">Barberos</x-nav-link>
                    <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.index')">Turnos</x-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                    @csrf
                    <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                        title="Cerrar sesión">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i><span class="sr-only">Cerrar sesión</span>
                    </x-nav-link>
                </form>
            @else
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')" title="Iniciar sesión">
                    <i class="fas fa-sign-in-alt" aria-hidden="true"></i><span class="sr-only">Iniciar sesión</span>
                </x-nav-link>
            @endauth
        </div>

        <!-- Hamburger button -->
        <div class="inline-flex sm:hidden">
            <button @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-menu"
                class="hover:text-yellow transition duration-150 ease-in-out" aria-label="Menú de navegación">
                <i :class="{ 'fa-solid fa-bars': !open, 'fa-solid fa-xmark': open }" class="text-2xl"
                    aria-hidden="true"></i>
            </button>
        </div>
    </nav>

    <!-- Responsive Navigation Menu -->
    <nav id="mobile-menu" :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden mt-4"
        aria-label="Navegación móvil">
        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Inicio</x-responsive-nav-link>
        <x-responsive-nav-link :href="'#about'" :active="request()->routeIs('about')">Nosotros</x-responsive-nav-link>
        <x-responsive-nav-link :href="'#contact'" :active="request()->routeIs('contact')">Contacto</x-responsive-nav-link>

        @auth
            @if (Auth::user()->role == 'user')
                <x-responsive-nav-link :href="route('appointments.available')" :active="request()->routeIs('appointments.available')">Turnos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('appointments.history')" :active="request()->routeIs('appointments.history')">Historial</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">Perfil</x-responsive-nav-link>
            @endif

            @if (Auth::user()->role == 'admin')
                <x-responsive-nav-link :href="route('barbers.index')" :active="request()->routeIs('barbers.index')">Barberos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.index')">Turnos</x-responsive-nav-link>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    Cerrar sesión
                </x-responsive-nav-link>
            </form>
        @else
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                Iniciar sesión
            </x-responsive-nav-link>
        @endauth
    </nav>
</header>
