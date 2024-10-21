<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css') <!-- Cargar CSS con Vite -->
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto">
            <a href="/" class="font-bold">Inicio</a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container mx-auto p-4 pb-16">
        @yield('content')
    </main>

    <!-- Footer fijo en la parte inferior -->
    <footer class="bg-gray-800 text-white p-4 w-full fixed bottom-0 left-0 z-10">
        <div class="container mx-auto text-center">
            © 2024 - Todos los derechos reservados.
        </div>
    </footer>

    @vite('resources/js/app.js') <!-- Cargar JS con Vite -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> <!-- Alpine.js -->
</body>
</html>
