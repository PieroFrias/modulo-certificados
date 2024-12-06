<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'CERTIFICADOS IIAP') }}</title>
    @vite('resources/css/app.css') <!-- Cargar CSS con Vite -->
</head>
<body class="bg-gray-100">
    {{-- <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Enlace de inicio -->
            <a href="{{ route('inicio.index') }}" class="font-bold">Inicio</a>

            <!-- Formulario de cierre de sesión -->
            @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="ml-4 text-white hover:text-gray-300">
                    Cerrar sesión
                </button>
            </form>
            @endauth
        </div>
    </nav> --}}
    <nav class="bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-500 py-2 px-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Menú hamburguesa -->
            <button id="menu-toggle" class="block sm:hidden text-white focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6h16.5m-16.5 6h16.5m-16.5 6h16.5" />
                </svg>
            </button>

            <!-- Contenedor para el contenido -->
            <div class="flex flex-1 justify-between items-center">
                <!-- Enlaces de navegación -->
                <div id="menu" class="hidden sm:flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 items-start sm:items-center sm:w-auto w-full">
                    <a href="{{ route('inicio.index') }}" class="text-xl font-medium text-white hover:text-gray-200">Inicio</a>
                    <a href="{{ route('certificados.index') }}" class="text-xl font-medium text-white hover:text-gray-200">Plantillas</a>
                    <a href="{{ route('curso.index') }}" class="text-xl font-medium text-white hover:text-gray-200">Cursos</a>
                    <a href="{{ route('alumno.index') }}" class="text-xl font-medium text-white hover:text-gray-200">Personas</a>
                </div>

                <!-- Botón de cierre de sesión -->
                @auth
                <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md shadow hover:bg-red-700">
                        Cerrar sesión
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container mx-auto p-4 pb-16">
        @yield('content')
    </main>

    {{-- <!-- Footer fijo en la parte inferior -->
    <footer class="bg-gray-800 text-white p-4 w-full fixed bottom-0 left-0 z-10">
        <div class="container mx-auto text-center">
            © 2024 - Todos los derechos reservados.
        </div>
    </footer> --}}

    @vite('resources/js/app.js') <!-- Cargar JS con Vite -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> <!-- Alpine.js -->

<!-- Script para manejar el menú hamburguesa -->
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>

</body>
</html>
