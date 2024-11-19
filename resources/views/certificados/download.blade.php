<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            text-align: center;
            position: relative;
        }

        .nombre-alumno {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 48px;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body>
    <!-- Aquí carga el contenido del PDF base -->

    <div class="nombre-alumno">
        {{ $alumno->nombre }} {{ $alumno->apellido }}
    </div>
</body>
</html>
