<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .iframe-container {
            flex-grow: 1;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        iframe {
            width: 90%;
            height: 90%;
            border: none;
        }

        .button-container {
            margin: 20px 0;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="iframe-container">
        <!-- Mostrar el PDF del certificado en pantalla completa -->
        <iframe src="{{ $pdfPath }}" title="Certificado de {{ $alumno->nombre }} {{ $alumno->apellido }}"></iframe>
    </div>

    <div class="button-container">
        <!-- Botón para regresar a la página principal -->
        <a href="{{ route('consulta.index') }}" class="btn">Regresar a la Consulta</a>
    </div>
</body>
</html>
