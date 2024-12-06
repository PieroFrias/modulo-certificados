<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Certificado Alumno</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-cover bg-center text-gray-800 font-sans">

    <!-- Aplicar estilos personalizados -->
    <style>
        body {
            background-image: url('{{ asset('images/consulta.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            body {
                background-image: url('{{ asset('images/fondo4consulta.jpg') }}');
                background-size: cover; /* Ajustar para cubrir todo el espacio */
                background-position: top;
            }
        }

        main {
            min-height: calc(100vh - 100px); /* Resta altura aproximada del header */
        }
    </style>

    <header class="bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-500 text-white py-6">
        <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between">
            <!-- Logo y título -->
            <div class="flex items-center space-x-4">
                <img src="https://aguasamazonicas.org/wp-content/uploads/2021/06/imagem_2023-05-29_120804614.png" alt="Logo" class="h-16 w-16 rounded-md">
                <h1 class="text-3xl font-bold">Consulta de Certificados IIAP</h1>
            </div>

            <!-- Botón de menú hamburguesa -->
            <button id="menu-toggle" class="lg:hidden flex items-center focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Menú -->
            <nav id="menu" class="mt-4 lg:mt-0 hidden lg:flex space-x-6 flex-col lg:flex-row">
                <a href="http://iiap.org.pe/web/presentacion_iiap.aspx" class="text-lg font-semibold hover:underline" target="_blank">IIAP</a>
                <a href="https://amazonia.iiap.gob.pe/" class="text-lg font-semibold hover:underline" target="_blank">Guía Ilustrada</a>
                <a href="http://ictiologicas.iiap.gob.pe/" class="text-lg font-semibold hover:underline" target="_blank">Ictiología</a>
                <a href="https://vertebrados.iiap.gob.pe/" class="text-lg font-semibold hover:underline" target="_blank">Vertebrados</a>
            </nav>
        </div>
    </header>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');

        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
    <!-- Contenido principal -->
<main class="container mx-auto mt-8 bg-opacity-90 rounded-lg p-6 flex flex-col lg:flex-row gap-8">
    <div class="lg:w-2/5 bg-white bg-opacity-90 p-8 rounded-lg shadow-lg">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Ingrese su correo o DNI</h2>
        <form action="{{ route('consulta.index') }}" method="GET" class="flex flex-col gap-6">
            <!-- Selector de tipo de búsqueda -->
            <div>
                <label for="search-type" class="block text-sm font-medium text-gray-700">Seleccione el tipo de búsqueda</label>
                <select id="search-type" onchange="toggleSearchInputs()" class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="correo" selected>Buscar por Correo</option>
                    <option value="dni">Buscar por DNI</option>
                </select>
            </div>

            <!-- Campo de entrada para DNI -->
            <div id="dni-input-container" class="hidden">
                <label for="dni-input" class="block text-sm font-medium text-gray-700">Ingrese su DNI</label>
                <input id="dni-input" type="number" name="dni" value="{{ request('dni') }}" placeholder="Ingrese su DNI"
                       class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400">
            </div>

            <!-- Campo de entrada para Correo -->
            <div id="correo-input-container">
                <label for="correo-input" class="block text-sm font-medium text-gray-700">Ingrese su Correo</label>
                <input id="correo-input" type="email" name="correo" value="{{ request('correo') }}" placeholder="Ingrese su correo"
                       class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none placeholder-gray-400">
            </div>

            <!-- Contenedor para botones -->
            <div class="flex justify-center gap-4">
                <!-- Botón Limpiar -->
                <button type="button" onclick="window.location.href='{{ route('consulta.index') }}'"
                        class="bg-gray-600 hover:bg-gray-500 text-white py-2 px-6 rounded-lg font-medium text-sm">
                    Limpiar
                </button>
                <!-- Botón Buscar -->
                <button type="submit" class="bg-green-600 hover:bg-green-500 text-white py-2 px-6 rounded-lg font-medium text-sm">
                    Buscar
                </button>
            </div>
        </form>
    </div>



    <!-- Columna derecha: espacio para resultados -->
    <div class="lg:w-2/3">
        @if ($alumnos && $alumnos->isNotEmpty())
            <div class="overflow-x-auto bg-white bg-opacity-90 p-6 rounded-lg shadow">
                <table class="table-auto w-full bg-white shadow-lg rounded-lg border-collapse">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Nombre</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Apellido</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">DNI</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Evento/curso</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumnos as $alumno)
                            <tr class="border-t border-gray-300 hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $alumno->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $alumno->apellido }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $alumno->dni }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ optional($alumno->curso)->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <div class="flex gap-2">
                                        @if ($alumno->codigo)
                                            <a href="{{ route('consulta.descargarCertificado', $alumno->codigo) }}"
                                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-center">Descargar</a>
                                        @else
                                            <span class="text-red-500">No disponible</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif (request()->has('dni') || request()->has('correo'))
            <!-- Mostrar mensaje cuando no hay resultados después de una búsqueda -->
            <div class="bg-red-100 text-red-700 p-4 rounded-lg shadow-lg">
                <p class="text-center font-medium">No se encontró ninguna persona con los datos proporcionados.</p>
            </div>
        @endif
    </div>

</main>

</body>
<script>
    function toggleSearchInputs() {
        const searchType = document.getElementById('search-type').value;
        const dniContainer = document.getElementById('dni-input-container');
        const correoContainer = document.getElementById('correo-input-container');

        if (searchType === 'dni') {
            dniContainer.classList.remove('hidden');
            correoContainer.classList.add('hidden');
        } else {
            correoContainer.classList.remove('hidden');
            dniContainer.classList.add('hidden');
        }
    }

    // Set default to 'correo'
    document.addEventListener('DOMContentLoaded', () => {
        toggleSearchInputs();
    });
</script>

</html>
