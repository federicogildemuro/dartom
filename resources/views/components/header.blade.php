<header x-data="{ open: false }" class="px-5 sm:px-10">
    <nav class="flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="hover:scale-110 transition duration-150 ease-in-out">
            <img src="{{ asset('storage/logo.png') }}" alt="Dartom Logo" class="h-32 object-contain">
        </a>

        <!-- Navigation Links -->
        <div class="hidden sm:inline-flex gap-10">
            <!-- Visible to all users (including authenticated and unauthenticated) -->
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Inicio
            </x-nav-link>

            <x-nav-link :href="'#about'" :active="request()->routeIs('about')">
                Nosotros
            </x-nav-link>

            <x-nav-link :href="'#contact'" :active="request()->routeIs('contact')">
                Contacto
            </x-nav-link>

            <!-- Visible to authenticated users only -->
            @auth
                <!-- Visible to users with 'user' role -->
                @if (Auth::user()->role == 'user')
                    <x-nav-link :href="route('appointments.available')" :active="request()->routeIs('appointments.available')">
                        <i class="fas fa-calendar-alt"></i>
                    </x-nav-link>

                    <x-nav-link :href="route('appointments.history')" :active="request()->routeIs('appointments.history')">
                        <i class="fas fa-history"></i>
                    </x-nav-link>

                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        <i class="fas fa-user"></i>
                    </x-nav-link>
                @endif

                <!-- Visible to users with 'admin' role -->
                @if (Auth::user()->role == 'admin')
                    <x-nav-link :href="route('barbers.index')" :active="request()->routeIs('barbers.index')">
                        Barberos
                    </x-nav-link>

                    <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.index')">
                        Turnos
                    </x-nav-link>
                @endif

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                    @csrf
                    <x-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                    </x-nav-link>
                </form>

                <!-- Visible to unauthenticated users only -->
            @else
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    <i class="fas fa-sign-in-alt"></i>
                </x-nav-link>
            @endauth
        </div>

        <!-- Hamburger button -->
        <div class="inline-flex sm:hidden">
            <button @click="open = !open" class="hover:text-yellow transition duration-150 ease-in-out">
                <i :class="{ 'fa-solid fa-bars': !open, 'fa-solid fa-xmark': open }" class="text-2xl"></i>
            </button>
        </div>
    </nav>

    <!-- Responsive Navigation Menu -->
    <nav :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <!-- Visible to all users (including authenticated and unauthenticated) -->
        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
            Inicio
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="'#about'" :active="request()->routeIs('about')">
            Nosotros
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="'#contact'" :active="request()->routeIs('contact')">
            Contacto
        </x-responsive-nav-link>

        <!-- Visible to authenticated users only -->
        @auth
            <!-- Visible to users with 'user' role -->
            @if (Auth::user()->role == 'user')
                <x-responsive-nav-link :href="route('appointments.available')" :active="request()->routeIs('appointments.available')">
                    Turnos
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('appointments.history')" :active="request()->routeIs('appointments.history')">
                    Historial
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    Perfil
                </x-responsive-nav-link>
            @endif

            <!-- Visible to users with 'admin' role -->
            @if (Auth::user()->role == 'admin')
                <x-responsive-nav-link :href="route('barbers.index')" :active="request()->routeIs('barbers.index')">
                    Barberos
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.index')">
                    Turnos
                </x-responsive-nav-link>
            @endif

            <!-- Logout option for authenticated users -->
            <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    Cerrar sesión
                </x-responsive-nav-link>
            </form>

            <!-- Visible to unauthenticated users only -->
        @else
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Login') }}
            </x-responsive-nav-link>
        @endauth
    </nav>
</header>
