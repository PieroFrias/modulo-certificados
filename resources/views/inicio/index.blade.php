<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-500  via-purple-600 to-indigo-600 py-2 px-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('inicio.index') }}" class="text-2xl font-bold text-white hover:text-gray-100">
                Inicio
            </a>
            <!-- Botón de cierre de sesión -->
            @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-md shadow hover:bg-red-800">
                    Cerrar sesión
                </button>
            </form>
            @endauth
        </div>
    </nav>

    <div class="container mx-auto py-10">
        <br>
        <h1 class="text-3xl font-semibold text-center mb-10 text-gray-800">
            Administración
        </h1>

        <!-- Contenedor principal con Flexbox -->
        <div class="flex flex-wrap justify-center gap-6 px-4 pb-10">
            <!-- Tarjeta Cursos -->
            <a href="{{ route('curso.index') }}" class="bg-gray-50 shadow-lg rounded-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition-shadow w-64 h-40">
                <div class="h-16 w-16 bg-blue-600 text-white flex items-center justify-center rounded-full mb-4">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                        <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                        <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-800">Eventos/Cursos</h2>
            </a>

            <!-- Tarjeta Alumnos -->
            <a href="{{ route('alumno.index') }}" class="bg-gray-50 shadow-lg rounded-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition-shadow w-64 h-40">
                <div class="h-16 w-16 bg-green-600 text-white flex items-center justify-center rounded-full mb-4">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-800">Personas</h2>
            </a>

            <!-- Tarjeta Certificados -->
            <a href="{{ route('certificados.index') }}" class="bg-gray-50 shadow-lg rounded-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition-shadow w-64 h-40">
                <div class="h-16 w-16 bg-purple-600 text-white flex items-center justify-center rounded-full mb-4">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6.905 9.97a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72V18a.75.75 0 0 0 1.5 0v-4.19l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                        <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-800">Plantillas</h2>
            </a>

            <!-- Tarjeta Consulta Generar Certificado -->
            <a href="{{ route('consulta.index') }}" class="bg-gray-50 shadow-lg rounded-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition-shadow w-64 h-40">
                <div class="h-16 w-16 bg-indigo-600 text-white flex items-center justify-center rounded-full mb-4">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-800">Consultar Certificado</h2>
            </a>
        </div>
    </div>
</body>

</html>
