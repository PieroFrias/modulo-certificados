<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Consulta de Certificado Alumno</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body id="banner" class="flex items-center p-24 w-full">
<style>
    .play-regular {
        font-family: "Play", serif;
        font-weight: 400;
        font-style: normal;
    }

    .play-bold {
        font-family: "Play", serif;
        font-weight: 700;
        font-style: normal;
    }

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
        z-index: 1000;
    }

    #banner {
        height: 100vh;
        width: 100%;
        background: url('{{ asset('images/bg-ofi.jpg') }}') no-repeat center center/cover;
        padding: 1rem; /* Añadido para dar espacio en dispositivos móviles */
    }

    #title-banner {
        font-family: "Play", serif;
        font-weight: 700;
        font-style: bold;
        -webkit-text-stroke: 2px white;
        font-size: 2rem; /* Tamaño de fuente más pequeño para móviles */
    }

    #footer-banner {
        font-family: "Play", serif;
        font-weight: 400;
        font-style: bold;
        font-size: 1.2rem; /* Tamaño de fuente más pequeño para móviles */
    }

    #banner button {
        background-color: #EB8021;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    #banner button:hover {
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

    /* Asegurarse de que la card esté oculta inicialmente */
    #searchResults {
        display: none; /* Oculta la card inicialmente */
    }

    /* Estilos para móviles */
    @media (max-width: 640px) {
        #banner {
            padding: 1rem;
        }

        #title-banner {
            font-size: 1.5rem;
        }

        #footer-banner {
            font-size: 1rem;
        }

        .navbar {
            padding: 0.5rem;
        }

        .navbar h1 {
            font-size: 1rem;
        }

        .navbar img {
            height: 40px;
            width: 40px;
        }

        #search-form-container {
            width: 100%;
            padding: 0;
        }

        #search-form {
            width: 100%;
        }

        #search-form input, #search-form select {
            width: 100%;
        }

        main {
            flex-direction: column;
            gap: 1rem;
        }

        section.bg-white\/90 {
            width: 100%;
            max-width: 100%;
        }
    }

    /* Estilos para tablets */
    @media (min-width: 641px) and (max-width: 1023px) {
        #banner {
            padding: 2rem;
        }

        #title-banner {
            font-size: 2rem;
        }

        #footer-banner {
            font-size: 1.5rem;
        }

        .navbar h1 {
            font-size: 1.5rem;
        }

        .navbar img {
            height: 50px;
            width: 50px;
        }

        #search-form-container {
            width: 80%;
        }

        main {
            flex-direction: column;
            gap: 2rem;
        }

        section.bg-white\/90 {
            width: 80%;
            max-width: 80%;
        }
    }

    /* Estilos para desktop */
    @media (min-width: 1024px) {
        #banner {
            padding: 4rem;
        }

        #title-banner {
            font-size: 3rem;
        }

        #footer-banner {
            font-size: 2rem;
        }

        .navbar h1 {
            font-size: 2rem;
        }

        .navbar img {
            height: 60px;
            width: 60px;
        }

        #search-form-container {
            width: 50%;
        }

        main {
            flex-direction: row;
            gap: 4rem;
        }

        section.bg-white\/90 {
            width: 50%;
            max-width: 50%;
        }
    }
</style>

    <header class="navbar text-white bg-black/90 shadow-lg shadow-black/40 py-6">
        <div class="container mx-auto flex items-center justify-between max-w-screen-xl flex-wrap p-4">
            <div class="flex items-center space-x-4">
                <img src="https://aguasamazonicas.org/wp-content/uploads/2021/06/imagem_2023-05-29_120804614.png" alt="Logo" class="h-16 w-16 rounded-md">
                <h1 class="text-xs sm:text-sm md:text-3xl font-bold">Consulta de Certificados IIAP</h1>
            </div>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full lg:block lg:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 text-white">
                    <li>
                        <a href="http://iiap.org.pe/web/presentacion_iiap.aspx" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">IIAP</a>
                    </li>
                    <li>
                        <a href="https://amazonia.iiap.gob.pe/" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Guía Ilustrada</a>
                    </li>
                    <li>
                        <a href="http://ictiologicas.iiap.gob.pe/" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Ictiología</a>
                    </li>
                    <li>
                        <a href="https://vertebrados.iiap.gob.pe/" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Vertebrados</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="flex flex-col lg:flex-row justify-center w-full gap-8">
    <div class="flex flex-col justify-center items-start gap-8 w-full lg:w-1/2">
        <section>
            <h1 id="title-banner" class="text-3xl sm:text-5xl text-white">
                TODOS TUS CERTIFICADOS
            </h1>
            <p id="footer-banner" class="text-lg text-white">EN UN SOLO LUGAR</p>
        </section>
        <section id="search-form-container" class="flex w-full lg:w-96 gap-6 p-4">
            <form id="search-form" action="{{ route('consulta.index') }}" method="GET" class="flex flex-col w-full gap-6">
                <div>
                    <label for="search-type" class="block text-sm font-medium text-white">Seleccione el tipo de búsqueda</label>
                    <select id="search-type" onchange="toggleSearchInputs()" class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg">
                        <option value="correo" selected>Buscar por Correo</option>
                        <option value="dni">Buscar por DNI</option>
                    </select>
                </div>
                <div id="dni-input-container" class="hidden">
                    <label for="dni-input" class="block text-sm font-medium text-white">Ingrese su DNI</label>
                    <input id="dni-input" type="number" name="dni" placeholder="Ingrese su DNI" class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg">
                </div>
                <div id="correo-input-container">
                    <label for="correo-input" class="block text-sm font-medium text-white">Ingrese su Correo</label>
                    <input id="correo-input" type="email" name="correo" placeholder="Ingrese su correo" class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg">
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="window.location.href='{{ route('consulta.index') }}'" class="text-white py-2 px-6 rounded-lg bg-gray-500">Limpiar</button>
                    <button  type="submit" class="bg-green-600 hover:bg-green-500 text-white py-2 px-6 rounded-lg">Buscar</button>
                </div>
            </form>
        </section>
        <a href="https://pixabay.com/es/users/bergslay-1151140/?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=6488472" class="relative right-0 text-xs text-black/40">Foto</a>
    </div>
    <section class=" bg-white/90 rounded-lg p-4 w-full lg:w-1/2 max-h-full">
        <div class="flex flex-col gap-4 w-full p-4">
            <h1 class="text-lg font-bold">Tus certificados</h1>
            @if (!$alumnos || $alumnos->isEmpty())
                @if (!request()->has('dni') && !request()->has('correo'))
                    <p class="text-sm text-gray-600">Realiza una búsqueda para mostrar los datos.</p>
                @endif
            @endif
        </div>
        @if ($alumnos && $alumnos->isNotEmpty())
            <div class="rounded-lg shadow-sm dark:bg-gray-700">
                <section class="p-4 md:p-5">
                    <ol class="relative border-s border-gray-400 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                        @foreach ($alumnos as $alumno)
                            <li class="mb-10 ms-8">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-gray-300 dark:ring-gray-700 dark:bg-gray-600 ring-offset-2 ring-offset-gray-100">
                                    <svg class="w-2.5 h-2.5 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"/>
                                    </svg>
                                </span>
                                <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{ optional($alumno->curso)->nombre }}</h3>
                                <p class="text-sm text-gray-700">{{ $alumno->nombre }}</p>
                                <p class="text-sm text-gray-700">{{ $alumno->apellido }}</p>
                                <div class="flex mt-4 gap-2">
                                    @if ($alumno->codigo)
                                        <a href="{{ route('consulta.descargarCertificado', $alumno->codigo) }}" class="py-2 px-3 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 hover:border-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                            <svg class="w-3 h-3 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                                <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                            </svg>
                                            Descargar
                                        </a>
                                    @else
                                        <span class="text-red-500">No disponible</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </section>
            </div>
        @elseif (request()->has('dni') || request()->has('correo'))
            <div class="bg-red-100 text-red-700 p-4 rounded-lg shadow-lg">
                <p class="text-center font-medium">No se encontró ninguna persona con los datos proporcionados.</p>
            </div>
        @endif
    </section>
</main>



    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
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

        document.addEventListener('DOMContentLoaded', () => {
            toggleSearchInputs();
        });
        
    </script>
</body>

</html>