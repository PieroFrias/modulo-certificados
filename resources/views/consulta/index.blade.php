<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Certificado Alumno</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-color: #1a202c; /* Fondo oscuro */
            color: #fff;
            font-family: 'Inter', sans-serif;
        }

        nav {
            width: 100%;
            background-color: #2d3748; /* Fondo del nav */
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #63b3ed;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding-top: 50px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Estilos de la barra de búsqueda tipo Google */
        .search-bar {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-bar input[type="text"] {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border-radius: 50px;
            border: none;
            background-color: #2d3748;
            color: #fff;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            outline: none;
            transition: background-color 0.3s ease;
        }

        .search-bar input[type="text"]::placeholder {
            color: #a0aec0;
        }

        .search-bar input[type="text"]:focus {
            background-color: #4a5568;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .search-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #3182ce;
            border: none;
            border-radius: 50%;
            padding: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background-color: #63b3ed;
        }

        .search-btn svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }

        table {
            width: 100%;
            margin-top: 2rem;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            background-color: #2d3748;
            color: #fff;
            border-bottom: 1px solid #4a5568;
        }

        table th {
            font-size: 1rem;
            font-weight: 600;
        }

        table td {
            font-size: 0.875rem;
        }

        table tbody tr:hover {
            background-color: #4a5568;
        }

        .btn-container {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #3182ce;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #63b3ed;
        }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="font-bold">Inicio</a>
    </nav>

    <div class="container mx-auto p-6">
        <h1>Consulta Certificado Alumno</h1>

        <div class="search-bar mb-6">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('consulta.index') }}" method="GET">
                <input type="text" name="dni" placeholder="Ingrese su DNI" class="border rounded">
                <button type="submit" class="search-btn">
                    <svg viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M10 2a8 8 0 105.293 14.293l5.707 5.707a1 1 0 01-1.414 1.414l-5.707-5.707A8 8 0 1010 2zm0 2a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </form>
        </div>

        @if ($alumno)
            <div class="mt-8">
                <h2 class="text-2xl font-semibold">Resultado de la búsqueda del alumno:</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Curso</th>
                            <th>Certificado</th> <!-- Nueva columna para el certificado -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $alumno->nombre }}</td>
                            <td>{{ $alumno->apellido }}</td>
                            <td>{{ $alumno->dni }}</td>
                            <td>{{ $alumno->curso->nombre }}</td>
                            <td>{{ $alumno->curso->certificado->nombre }}</td> <!-- Mostrar el nombre del certificado -->
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Botones para descargar y ver certificado -->
            <div class="btn-container">
                <a href="{{ route('consulta.index', ['dni' => $alumno->dni, 'action' => 'download']) }}" class="btn">Descargar Certificado</a>

                <a href="{{ route('consulta.index', ['dni' => $alumno->dni, 'action' => 'view']) }}" class="btn">Ver Certificado</a>
            </div>
        @endif
    </div>
</body>
</html>
