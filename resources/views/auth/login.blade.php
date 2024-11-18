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
            <img src="https://aguasamazonicas.org/wp-content/uploads/2021/06/imagem_2023-05-29_120804614.png" alt="Logo" class="h-16 w-16 rounded-md">
        </div>
        <!-- Enlaces -->
        <div class="flex space-x-6">
            <a href="http://iiap.org.pe/web/presentacion_iiap.aspx" class="text-black text-lg font-bold hover:text-gray-600">IIAP</a>
            <a href="https://amazonia.iiap.gob.pe/" class="text-black text-lg font-bold hover:text-gray-600">Guía Ilustrada</a>
            <a href="http://ictiologicas.iiap.gob.pe/" class="text-black text-lg font-bold hover:text-gray-600">Ictiología</a>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="flex-grow flex px-4">
        <!-- Texto al lado izquierdo -->
        <div class="w-1/2 flex items-center justify-center">
            <h1 class="text-5xl font-bold uppercase text-center" style="color: #FF9800; text-shadow: -4px -4px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
                certificados IIAP
            </h1>

        </div>

        <!-- Formulario al lado derecho -->
        <div class="w-1/2 flex justify-center items-center">
            <form action="{{ route('login') }}" method="POST" class="bg-white bg-opacity-80 backdrop-blur-3xl p-8 md:p-16 rounded-lg shadow-lg w-full max-w-lg">
                @csrf
                {{-- <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Iniciar sesión</h1> --}}
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
                    <!-- Botón para ver u ocultar contraseña -->
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
            'https://www.peru.travel/Contenido/Destino/Imagen/es/9/1.2/Principal/Loreto.jpg',
            'https://www.raptravelperu.com/wp-content/uploads/portada-rio-amazonas-iquitos.webp',
            'https://investigacion.pucp.edu.pe/grupos/antropologia-ciudad/wp-content/uploads/sites/238/2019/04/espacio-fluvial-e1689201437565.jpg',
            'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiWEhfteH5_H4_Ddhvizr7NLhuHSFTIx-A-V9Sp6KPu-IOH88ILbQ6-0iBnr03BNdB5rms997Sm4v3ee4gKR9sbCl65oZad97KYFOQhOt-YEPNqChMe_8hM2uiy_qGYN3c5hwRdPHOa_ZE7/s1600/2.+Amazonas+Peru+(36).jpg'
        ];

        let currentIndex = 0;

        // Función para cambiar el fondo dinámicamente
        function changeBackground() {
            document.body.style.backgroundImage = `url('${images[currentIndex]}')`;
            currentIndex = (currentIndex + 1) % images.length; // Avanza al siguiente índice en bucle
        }

        // Cambiar fondo cada 5 segundos
        setInterval(changeBackground, 5000);

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
