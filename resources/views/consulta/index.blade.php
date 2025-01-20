<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Certificado Alumno</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body>
    <!-- Aplicar estilos personalizados -->
    <style>
        /* 
        @media (max-width: 768px) {
            body {
                background-image: url('{{ asset('images/fondo4consulta.jpg') }}');
                background-size: cover;
                background-position: top;
            }
        }
        .play-regular {
            font-family: "Play", serif;
            font-weight: 400;
            font-style: normal;
        }

        .play-bold {
            font-family: "Play", serif;
            font-weight: 700;
            font-style: normal;
        } */
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            z-index: 1000;
        }

        .banner {
            height: 100vh; /* Ocupa toda la pantalla */
            width: 100%;
            background: url('{{ asset('images/bg-ofi.jpg') }}') no-repeat center center/cover;
            display: flex;
            color: white;
        }

        .form-section {
            padding: 50px 20px;
            background-color: #f4f4f4;
        }

        #title-banner{
            font-family: "Play", serif;
            font-weight: 700;
            font-style: bold;
            -webkit-text-stroke: 2px white;
        }
        #footer-banner{
            font-family: "Play", serif;
            font-weight: 400;
            font-style: bold;
        }

        .banner button {
            margin-top: 2rem;
            padding: 1rem 2rem;
            background-color: #EB8021;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .banner button:hover {
            transform: scale(1.05);
        }

        #menu {
            transition: transform 0.3s ease-in-out;
            transform: translateY(-100%);
        }

        #menu.active {
            transform: translateY(0);
        }

        @media (min-width: 1024px) {
            #menu {
                transform: none;
            }
        }


    </style>

    <header class="navbar text-white bg-white/10 shadow-lg shadow-black/40 py-6">
        <div class="container mx-auto flex  items-center justify-between max-w-screen-xl  flex-wrap p-4">
            <!-- Logo y título -->
            <div class="flex items-center space-x-4">
                <img src="https://aguasamazonicas.org/wp-content/uploads/2021/06/imagem_2023-05-29_120804614.png" alt="Logo" class="h-16 w-16 rounded-md">
                <h1 class="text-sm md:text-3xl font-bold">Consulta de Certificados IIAP</h1>
            </div>

            <!-- Botón de menú hamburguesa -->
            <!-- <button id="menu-toggle" class="lg:hidden flex items-center focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
            </button> -->
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>

            <!-- Menú -->
            <div class="hidden w-full lg:block lg:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 rounded-lg  md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 text-white">
                    <li>
                    <a href="http://iiap.org.pe/web/presentacion_iiap.aspx" class="block py-2 px-3  rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">IIAP</a>
                    </li>
                    <li>
                    <a href="https://amazonia.iiap.gob.pe/" class="block py-2 px-3  rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Guía Ilustrada</a>
                    </li>
                    <li>
                    <a href="http://ictiologicas.iiap.gob.pe/" class="block py-2 px-3  rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Ictiología</a>
                    </li>
                    <li>
                    <a href="https://vertebrados.iiap.gob.pe/" class="block py-2 px-3  rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Vertebrados</a>
                    </li>
                </ul>
            </div>
        </div>    
    </header>

    <!-- Contenido principal -->
    <div  class="banner flex flex-col gap-8 p-6 justify-center items-start">
        <div class=" flex flex-col">
            <h1 id="title-banner" class="text-5xl  text-white">
                TODOS TUS CERTIFICADOS
            </h1>
            <p id="footer-banner" class="text-lg text-white">EN UN SOLO LUGAR</p>
        </div>
        <button id="footer-banner" class="bg-[#EB8021] rounded-lg p-4 text-sm text-white scale-100 hover:scale-105">¡CONSULTAR AQUI!</button>
    </div>
    <main class="form-section flex flex-col gap-4 w-full">
        <!-- Form Section -->
            <section class="flex flex-col w-96 bg-red-100 p-4 gap-4 rounded shadow">
                <h1 class="text-lg font-bold">Formulario de búsqueda</h1>
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
            </section>
            <section class="flex flex-col gap-4 w-full bg-red-100 p-4 rounded shadow">
                <h1 class="text-lg font-bold">Tus certificados</h1>
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
            </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
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
