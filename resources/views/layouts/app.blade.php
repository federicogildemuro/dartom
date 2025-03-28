<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Title -->
    <title>Dartom | Barbería tradicional</title>
</head>

<body class="antialiased">
    <div class="min-h-screen">
        <x-header />

        <main>
            {{ $slot }}
        </main>

        <x-footer />
    </div>

    <!-- Font Awesome Script -->
    <script src="https://kit.fontawesome.com/fc6964b5bb.js" crossorigin="anonymous"></script>
</body>

</html>
