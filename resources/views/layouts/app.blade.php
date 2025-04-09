<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>Dartom | Barbería tradicional</title>

    <!-- Meta description -->
    <meta name="description"
        content="Dartom, barbería tradicional en Mar del Plata. Turnos online, cortes clásicos, modernos y arreglo de barba. Atención personalizada.">

    <!-- Meta keywords -->
    <meta name="keywords" content="barbería, turnos online, cortes de pelo, barba, Mar del Plata, Dartom">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

    <!-- Open Graph -->
    <meta property="og:title" content="Dartom | Barbería Tradicional" />
    <meta property="og:description"
        content="Sacá tu turno online en Dartom, barbería tradicional en Mar del Plata. Cortes, barbas y más" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset('og-image.png') }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Dartom | Barbería Tradicional">
    <meta name="twitter:description"
        content="Sacá tu turno online en Dartom, barbería tradicional en Mar del Plata. Cortes, barbas y más">
    <meta name="twitter:image" content="{{ asset('og-image.png') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="min-h-screen">
        <x-header />

        <main class="pt-32">
            {{ $slot }}
        </main>

        <x-footer />
    </div>

    <!-- Scroll to Top Button -->
    <x-scroll-to-top />

    <!-- Font Awesome Script -->
    <script src="https://kit.fontawesome.com/fc6964b5bb.js" crossorigin="anonymous"></script>
</body>

</html>
