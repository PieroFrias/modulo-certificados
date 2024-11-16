<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Certificado Alumno</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white font-sans">
    <nav class="w-full bg-gray-800 py-4 px-6 shadow-md flex justify-between items-center">
        <a href="/" class="text-white text-lg font-bold hover:text-blue-400">Inicio</a>
    </nav>

    <div class="container mx-auto p-6">
        <h1 class="text-center text-4xl font-bold mb-6">Consulta Certificado Alumno</h1>



        <div class="search-bar mb-6 max-w-lg mx-auto relative">
            <form action="{{ route('consulta.index') }}" method="GET">
                <input
                    type="text"
                    name="dni"
                    placeholder="Ingrese su DNI"
                    class="w-full p-4 rounded-full border-none bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-700"
                    value="{{ old('dni') }}">
                    <button
                        type="submit"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white p-2 rounded-full hover:bg-blue-400 mx-2">
                            <svg viewBox="0 0 24 24" class="w-6 h-6" style="fill: white;">
                                <path fill-rule="evenodd" d="M10 2a8 8 0 105.293 14.293l5.707 5.707a1 1 0 01-1.414 1.414l-5.707-5.707A8 8 0 1010 2zm0 2a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd" />
                            </svg>
                    </button>


            </form>
        </div>

        <!-- Mostrar mensajes de error con un contenedor dinámico -->
        @if ($errors->any())
            <div id="error-messages" class="bg-red-500 text-white p-4 rounded mb-6">
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($alumnos && $alumnos->isNotEmpty())
            <div class="mt-8">
                <h2 class="text-2xl font-semibold mb-4">Resultados de la búsqueda del alumno:</h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-800">
                                <th class="px-4 py-2">Nombre</th>
                                <th class="px-4 py-2">Apellido</th>
                                <th class="px-4 py-2">DNI</th>
                                <th class="px-4 py-2">Curso</th>
                                <th class="px-4 py-2">Certificado</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                <tr class="odd:bg-gray-800 even:bg-gray-700 hover:bg-gray-600">
                                    <td class="px-4 py-2">{{ $alumno->nombre }}</td>
                                    <td class="px-4 py-2">{{ $alumno->apellido }}</td>
                                    <td class="px-4 py-2">{{ $alumno->dni }}</td>
                                    <td class="px-4 py-2">{{ optional($alumno->curso)->nombre }}</td>
                                    <td class="px-4 py-2">{{ optional(optional($alumno->curso)->certificado)->nombre }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <a href="{{ route('consulta.index', ['dni' => $alumno->dni, 'action' => 'download', 'curso_id' => optional($alumno->curso)->idcurso]) }}"
                                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-400 text-center">
                                                Descargar Certificado
                                            </a>
                                            <a href="{{ route('consulta.index', ['dni' => $alumno->dni, 'action' => 'view', 'curso_id' => optional($alumno->curso)->idcurso]) }}"
                                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-400 text-center"
                                                target="_blank" rel="noopener noreferrer">
                                                Ver Certificado
                                             </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
        <div class="mt-8 text-center">
            @if (request()->has('dni') && $alumnos->isEmpty())
                <h2 class="text-xl font-semibold">No se encontraron resultados para el DNI ingresado.</h2>
            @endif
        </div>

        @endif
    </div>

    <!-- Script para ocultar automáticamente el mensaje de error -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const errorMessages = document.getElementById('error-messages');
            if (errorMessages) {
                setTimeout(() => {
                    errorMessages.style.transition = "opacity 0.5s ease";
                    errorMessages.style.opacity = "0";
                    setTimeout(() => errorMessages.remove(), 500); // Eliminar del DOM después de desaparecer
                }, 3000); // Cambia este valor para ajustar el tiempo de visibilidad (3 segundos)
            }
        });
    </script>
</body>

</html>
