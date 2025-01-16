<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Certificado Alumno</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body>
    <!-- Aplicar estilos personalizados -->
    <style>
        body {
            background-image: url('{{ asset('images/bg-ofi.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            width: 100%;
            overflow: hidden;
            margin: 0;
        }

        @media (max-width: 768px) {
            body {
                background-image: url('{{ asset('images/fondo4consulta.jpg') }}');
                background-size: cover; /* Ajustar para cubrir todo el espacio */
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




        main {
            min-height: calc(100vh - 100px); /* Resta altura aproximada del header */
        }
    </style>

    <header class="text-white bg-white/10 shadow-lg shadow-black/40 py-6">
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
    <main class="flex justify-start items-center p-4">
        <div class="flex flex-col ml-16 gap-8 items-start">
            <div class="flex flex-col">
                <h1 id="title-banner" class="text-5xl  text-white">
                    TODOS TUS CERTIFICADOS
                </h1>
                <p id="footer-banner" class="text-2xl text-white">EN UN SOLO LUGAR</p>
            </div>
            <button id="footer-banner" class="bg-[#EB8021] rounded-lg p-4 text-sm text-white scale-100 hover:scale-105">¡CONSULTAR AQUI!</button>
        </div>
        
        <!-- Form Section -->
        <!-- <section class="flex flex-col w-96 bg-red-100 p-4 rounded shadow">
            <h1 class="text-lg font-bold">Form</h1>
        </section>
        <section class="flex flex-col w-96 bg-red-100 p-4 rounded shadow">
            <h1 class="text-lg font-bold">dv</h1>
        </section> -->
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
