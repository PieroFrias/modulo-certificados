<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white font-sans">
    <div class="flex flex-col lg:flex-row items-center justify-center h-screen lg:px-24">
        <!-- Sección izquierda -->
        <div class="text-center lg:text-left mb-10 lg:mb-0 lg:w-1/2">
            <h1 class="text-5xl font-bold text-blue-500">MiAplicación</h1>
            <p class="mt-4 text-lg text-gray-300">Tu plataforma para conectarte con el mundo y compartir ideas importantes para tu vida.</p>
        </div>

        <!-- Formulario de inicio de sesión -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg lg:w-1/3 w-full max-w-md">
            <form  class="space-y-4">
                @csrf
                <!-- Campo de correo -->
                <div>
                    <label for="email" class="block text-sm font-medium">Correo electrónico o número de teléfono</label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        class="mt-1 w-full px-4 py-2 rounded border border-gray-700 bg-gray-900 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Ingresa tu correo o número de teléfono"
                        required>
                </div>

                <!-- Campo de contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="mt-1 w-full px-4 py-2 rounded border border-gray-700 bg-gray-900 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Ingresa tu contraseña"
                        required>
                </div>

                <!-- Botón de inicio de sesión -->
                <div>
                    <button
                        type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-400 text-white py-2 px-4 rounded font-medium">
                        Iniciar sesión
                    </button>
                </div>

                <!-- Enlaces adicionales -->
                <div class="text-center mt-4">
                    <a  class="text-sm text-blue-400 hover:underline">¿Olvidaste tu contraseña?</a>
                </div>
            </form>

            <!-- Separador -->
            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-600">
                <span class="px-4 text-gray-400 text-sm">o</span>
                <hr class="flex-grow border-gray-600">
            </div>

            <!-- Botón para crear cuenta -->
            <div class="text-center">
                <a 
                    class="w-full bg-green-500 hover:bg-green-400 text-white py-2 px-4 rounded font-medium inline-block">
                    Crear cuenta nueva
                </a>
            </div>
        </div>
    </div>
</body>

</html>
