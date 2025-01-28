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

        .banner {
            height: 100vh; /* Ocupa toda la pantalla */
            width: 100%;
            background: url('{{ asset('images/bg-ofi.jpg') }}') no-repeat center center/cover;
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

    <header class="navbar text-white bg-black/90 shadow-lg shadow-black/40 py-6">
        <div class="container mx-auto flex  items-center justify-between max-w-screen-xl  flex-wrap p-4">
            <!-- Logo y título -->
            <div class="flex items-center space-x-4">
                <img src="https://aguasamazonicas.org/wp-content/uploads/2021/06/imagem_2023-05-29_120804614.png" alt="Logo" class="h-16 w-16 rounded-md">
                <h1 class="text-xs sm:text-sm md:text-3xl font-bold">Consulta de Certificados IIAP</h1>
            </div>

            <!-- Botón de menú hamburguesa -->

            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
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
    <div class="banner flex flex-col justify-center items-start p-24">
        <main class="flex flex-col gap-8 w-full max-w-md justify-center items-start">
            <section class="">
                <h1 id="title-banner" class="text-3xl sm:text-5xl  text-white">
                  TODOS TUS CERTIFICADOS
                </h1>
                <p id="footer-banner" class="text-lg text-white">EN UN SOLO LUGAR</p>
            </section>
            <section class="flex flex-col gap-4 bg-slate-300/50 p-8 rounded-lg w-full">
                <!-- <h1 class="text-xl font-bold text-center sm:text-left">Formulario de búsqueda</h1> -->
                <form id="search-form" action="{{ route('consulta.index') }}" method="GET" class="flex flex-col w-full gap-6">
                    <!-- Selector de tipo de búsqueda -->
                    <div>
                        <label for="search-type" class="block text-sm font-medium text-white">Seleccione el tipo de búsqueda</label>
                        <select 
                        id="search-type" 
                        onchange="toggleSearchInputs()" 
                        class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="correo" selected>Buscar por Correo</option>
                            <option value="dni">Buscar por DNI</option>
                        </select>
                    </div>
                
                    <!-- Campo de entrada para DNI -->
                    <div id="dni-input-container" class="hidden">
                        <label for="dni-input" class="block text-sm font-medium text-white">Ingrese su DNI</label>
                        <input 
                        id="dni-input" 
                        type="number" 
                        name="dni" 
                        value="{{ request('dni') }}" 
                        placeholder="Ingrese su DNI"
                        class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400"
                        >
                    </div>
                
                    <!-- Campo de entrada para Correo -->
                    <div id="correo-input-container">
                        <label for="correo-input" class="block text-sm font-medium text-white">Ingrese su Correo</label>
                        <input 
                        id="correo-input" 
                        type="email" 
                        name="correo" 
                        value="{{ request('correo') }}" 
                        placeholder="Ingrese su correo"
                        class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none placeholder-gray-400"
                        >
                    </div>
                
                    <!-- Contenedor para botones -->
                    <div class="flex flex-col sm:flex-row justify-center md:justify-end p-4 gap-4">
                        <!-- Botón Limpiar -->
                        <button
                        type="button" 
                        onclick="window.location.href='{{ route('consulta.index') }}'"
                        class="flex items-center justify-center text-white p-4 rounded-lg font-medium text-sm w-full h-10 sm:w-auto"
                        >
                        Limpiar
                        </button>
                        <!-- Botón Buscar -->
                        <button
                            data-modal-target="timeline-modal" data-modal-toggle="timeline-modal"
                            type="submit"
                            class="bg-green-600 hover:bg-green-500 text-white py-2 px-6 rounded-lg font-medium text-sm w-full sm:w-auto"
                        >
                        Buscar
                        </button>
                    </div>
                </form>
            </section>
        </main>
        <a href="https://pixabay.com/es/users/bergslay-1151140/?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=6488472" class="relative right-0 text-xs text-black/40">Foto</a> 
    </div>
    <!-- Main modal -->
    <div id="timeline-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white/90 rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Tus certificados
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="timeline-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        @if (!$alumnos || $alumnos->isEmpty())
                            @if (!request()->has('dni') && !request()->has('correo'))
                                <p class="text-sm text-gray-600">Realiza una búsqueda para mostrar los datos.</p>
                            @endif
                        @endif
                        <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">                  
                            @if ($alumnos && $alumnos->isNotEmpty())
                                @foreach ($alumnos as $alumno)
                                    <li class="mb-10 ms-8">
                                        <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-gray-300 dark:ring-gray-700 dark:bg-gray-600 ring-offset-2 ring-offset-gray-100">
                                            <svg class="w-2.5 h-2.5 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"/></svg>
                                        </span>
                                        <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{ optional($alumno->curso)->nombre }}<span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300 ms-3">Latest</span></h3>
                                        <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">Released on Nov 10th, 2023</time>
                                        <div class="flex gap-2">
                                            @if ($alumno->codigo)
                                            <a href="{{ route('consulta.descargarCertificado', $alumno->codigo) }}"
                                                class="py-2 px-3 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 hover:border-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                <svg class="w-3 h-3 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/><path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/></svg>
                                                Descargar
                                            </a>
                                            
                                            @else
                                                <span class="text-red-500">No disponible</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            @elseif (request()->has('dni') || request()->has('correo'))
                                <!-- Mostrar mensaje cuando no hay resultados después de una búsqueda -->
                                <div class="bg-red-100 text-red-700 p-4 rounded-lg shadow-lg">
                                    <p class="text-center font-medium">No se encontró ninguna persona con los datos proporcionados.</p>
                                </div>
                            @endif
                        </ol>
                    </div>
                </div>
        </div>
    </div> 
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

    // document.getElementById('search-form').addEventListener('submit', function(event) {
    //     event.preventDefault(); // Evita la recarga de la página

    //     // Obtener los datos del formulario
    //     const dni = document.getElementById('dni').value;
    //     const correo = document.getElementById('correo').value;
    //     const resultadosDiv = document.getElementById('resultados');

    //     // Construir la URL con los parámetros de búsqueda
    //     const url = `{{ route('consulta.index') }}?dni=${dni}&correo=${correo}`;

    //     // Hacer la petición con fetch
    //     fetch(url, {
    //         method: 'GET',
    //         headers: {
    //             'X-Requested-With': 'XMLHttpRequest' // Indicar que es una petición AJAX
    //         }
    //     })
    //     .then(response => response.text()) // Convertir la respuesta en texto (HTML)
    //     .then(html => {
    //         resultadosDiv.innerHTML = html; // Insertar la respuesta en el div de resultados
    //     })
    //     .catch(error => console.error('Error en la búsqueda:', error));
    // });
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita la recarga de la página

        // Obtener los datos del formulario
        const formData = new FormData(this);
        const url = this.action;

        // Hacer la petición con fetch
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indicar que es una petición AJAX
            },
            body: formData
        })
        .then(response => response.text()) // Convertir la respuesta en texto (HTML)
        .then(html => {
            // Actualizar el contenido de la modal con la respuesta
            document.getElementById('modal-body').innerHTML = html;
            
            // Mostrar la modal
            const modal = new Flowbite.Modal(document.getElementById('timeline-modal'));
            modal.show();
        })
        .catch(error => console.error('Error en la búsqueda:', error));
    });
</script>

</html>
