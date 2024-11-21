<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Estilo inicial para el fondo dinámico */
        body {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transition: background-image 1s ease-in-out;
        }
    </style>


</head>
<body class="bg-gray-900 bg-opacity-80 text-white flex flex-col h-screen">

    <!-- Navbar -->
    <nav class="bg-white p-1 flex items-center shadow-md">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo1.webp') }}" alt="Logo" class="h-16 w-16 rounded-md">
        </div>
        <!-- Enlaces -->
        <div class="flex space-x-6">
            <a href="http://iiap.org.pe/web/presentacion_iiap.aspx" class="text-black text-lg font-bold hover:text-gray-600">IIAP</a>
            <a href="https://amazonia.iiap.gob.pe/" class="text-black text-lg font-bold hover:text-gray-600">Guía Ilustrada</a>
            <a href="http://ictiologicas.iiap.gob.pe/" class="text-black text-lg font-bold hover:text-gray-600">Ictiología</a>
        </div>
    </nav>

    <div class="flex-grow flex px-4 flex-wrap">
        <!-- Texto al lado izquierdo o encima en pantallas pequeñas -->
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center mb-1 lg:mb-0">
            <h1 class="text-4xl lg:text-6xl font-bold uppercase text-center leading-tight lg:leading-normal"
                style="color: #FF9800; -webkit-text-stroke: 2px white; text-stroke: 2px white; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);">
                <span class="block lg:inline">CERTIFICADOS</span>
                <span class="block lg:inline">IIAP</span>
            </h1>
            <!-- Logo debajo de las letras -->
            <img src="{{ asset('images/logo2.png') }}" alt="Logo IIAP" class="h-32 w-32 lg:h-64 lg:w-64 mt-4 mx-auto">

        </div>






       <!-- Formulario -->
        <div class="w-full lg:w-1/2 flex justify-center items-start lg:items-center sm:mt-[-40px]">
            <form action="{{ route('login') }}" method="POST" class="bg-white bg-opacity-80 backdrop-blur-3xl p-8 md:p-16 rounded-lg shadow-lg w-full max-w-lg">
                @csrf
                @if ($errors->any())
                    <div class="text-red-500 text-sm mb-4">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-800">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="w-full p-3 mt-2 rounded bg-gray-200 text-gray-800 focus:outline-none focus:ring focus:ring-blue-500">
                </div>
                <div class="mb-6 relative">
                    <label for="password" class="block text-sm font-medium text-gray-800">Contraseña</label>
                    <input type="password" id="password" name="password" class="w-full p-3 mt-2 rounded bg-gray-200 text-gray-800 focus:outline-none focus:ring focus:ring-blue-500">
                    <button type="button"
                        onclick="togglePasswordVisibility('password')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600">
                        👁️
                    </button>
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-400 text-white py-3 px-4 rounded-lg font-semibold">
                    Iniciar sesión
                </button>
            </form>
        </div>

    </div>



    <script>
        // Array de URLs de las imágenes
        const images = [
            "{{ asset('images/fondo1.jpg') }}",
            "{{ asset('images/fondo2.webp') }}",
            "{{ asset('images/fondo3.jpg') }}",
            "{{ asset('images/fondo4.jpg') }}"
        ];

        let currentIndex = 0;

        // Pre-cargar imágenes
        const preloadedImages = [];
        images.forEach((src) => {
            const img = new Image();
            img.src = src;
            preloadedImages.push(img);
        });

        // Función para cambiar el fondo dinámicamente
        function changeBackground() {
            const nextImage = preloadedImages[currentIndex].src; // Obtiene la URL de la imagen precargada
            document.body.style.backgroundImage = `url('${nextImage}')`;
            currentIndex = (currentIndex + 1) % images.length; // Avanza al siguiente índice en bucle
        }

        // Cambiar fondo cada 5 segundos
        setInterval(changeBackground, 4000);

        // Establecer el fondo inicial
        changeBackground();
    </script>


<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        if (field.type === 'password') {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    }
</script>

</body>
</html>
