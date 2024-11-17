<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-500 py-2 px-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('inicio.index') }}" class="text-2xl font-bold text-white hover:text-gray-200">
                Inicio
            </a>
            <!-- Botón de cierre de sesión -->
            @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md shadow hover:bg-red-700">
                    Cerrar sesión
                </button>
            </form>
            @endauth
        </div>
    </nav>

    <div class="container mx-auto py-10">
        <br>
        <h1 class="text-3xl font-semibold text-center mb-10 text-gray-700">
            Panel de Administración
        </h1>

        <!-- Fila de tarjetas con gap -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
            <!-- Tarjeta Cursos -->
            <a href="{{ route('curso.index') }}" class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition-shadow">
                <div class="h-16 w-16 bg-blue-500 text-white flex items-center justify-center rounded-full mb-4">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7h20L12 2z" />
                        <path d="M2 9v11a1 1 0 001 1h4v-9h10v9h4a1 1 0 001-1V9H2z" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-700">Eventos/Cursos</h2>
            </a>

            <!-- Tarjeta Alumnos -->
            <a href="{{ route('alumno.index') }}" class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition-shadow">
                <div class="h-16 w-16 bg-green-500 text-white flex items-center justify-center rounded-full mb-4">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z" />
                        <path d="M6 20v-1c0-2.67 5.33-4 6-4s6 1.33 6 4v1H6z" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-700">Personas</h2>
            </a>

            <!-- Tarjeta Certificados -->
            <a href="{{ route('certificados.index') }}" class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition-shadow">
                <div class="h-16 w-16 bg-purple-500 text-white flex items-center justify-center rounded-full mb-4">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-700">Plantillas</h2>
            </a>

            <!-- Tarjeta Consulta Generar Certificado -->
            <a href="{{ route('consulta.index') }}" class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition-shadow">
                <div class="h-16 w-16 bg-indigo-500 text-white flex items-center justify-center rounded-full mb-4">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M10 2a8 8 0 105.293 14.293l5.707 5.707a1 1 0 01-1.414 1.414l-5.707-5.707A8 8 0 1010 2zm0 2a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-700">Consultar Certificado</h2>
            </a>
        </div>
    </div>

    <footer class="bg-gray-800 text-white p-4 w-full fixed bottom-0 left-0 z-10">
        <div class="container mx-auto text-center">
            © 2024 - Todos los derechos reservados.
        </div>
    </footer>
</body>

</html>
