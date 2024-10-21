<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    @vite('resources/css/app.css')
    <style>
        /* Estilos personalizados para las animaciones */
        .card {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 40rem; /* Limitar el ancho máximo de las tarjetas en pantallas grandes */
            width: 100%; /* Asegurar que ocupe todo el ancho disponible */
            margin: 0 auto; /* Centrar las tarjetas */
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .card::before {
            content: '';
            position: absolute;
            top: -75%;
            left: -75%;
            width: 50%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15), transparent 70%);
            transform: rotate(45deg);
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .card:hover::before {
            opacity: 1;
            animation: shine 0.75s forwards;
        }

        @keyframes shine {
            from {
                transform: rotate(45deg) translate(-100%, 0);
            }

            to {
                transform: rotate(45deg) translate(200%, 0);
            }
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 800px; /* Para pantallas grandes, limitar el ancho total */
            }
        }
    </style>
</head>

<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold mb-10 text-center">Panel de Administración</h1>

        <!-- Fila de tarjetas -->
        <div class="grid grid-cols-1 gap-8 mb-24">
            <!-- Tarjeta Cursos -->
            <a href="{{ route('curso.index') }}" class="card bg-gray-800 shadow-lg rounded-xl p-8 text-white h-56 flex flex-col justify-center">
                <div class="flex items-center justify-center h-20 w-20 mx-auto bg-blue-700 rounded-full mb-6">
                    <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7h20L12 2z" />
                        <path d="M2 9v11a1 1 0 001 1h4v-9h10v9h4a1 1 0 001-1V9H2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-center">Cursos</h2>
            </a>

            <!-- Tarjeta Alumnos -->
            <a href="{{ route('alumno.index') }}" class="card bg-gray-800 shadow-lg rounded-xl p-8 text-white h-56 flex flex-col justify-center">
                <div class="flex items-center justify-center h-20 w-20 mx-auto bg-green-700 rounded-full mb-6">
                    <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z" />
                        <path d="M6 20v-1c0-2.67 5.33-4 6-4s6 1.33 6 4v1H6z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-center">Alumnos</h2>
            </a>

            <!-- Tarjeta Certificados -->
            <a href="{{ route('certificados.index') }}" class="card bg-gray-800 shadow-lg rounded-xl p-8 text-white h-56 flex flex-col justify-center">
                <div class="flex items-center justify-center h-20 w-20 mx-auto bg-purple-700 rounded-full mb-6">
                    <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-center">Certificados</h2>
            </a>

            <!-- Tarjeta Consulta Generar Certificado -->
            <a href="{{ route('consulta.index') }}" class="card bg-gray-800 shadow-lg rounded-xl p-8 text-white h-56 flex flex-col justify-center">
                <div class="flex items-center justify-center h-20 w-20 mx-auto bg-indigo-700 rounded-full mb-6">
                    <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M10 2a8 8 0 105.293 14.293l5.707 5.707a1 1 0 01-1.414 1.414l-5.707-5.707A8 8 0 1010 2zm0 2a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-center">Consulta Generar Certificado</h2>
            </a>
        </div>
    </div>
</body>

</html>
