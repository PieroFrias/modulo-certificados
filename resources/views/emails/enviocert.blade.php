<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px; /* Tamaño ajustado para que quede balanceado con el título */
            margin-right: 15px;
        }
        .header-title {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://lh4.googleusercontent.com/proxy/iXMnCAm4_rwKRj-dCclpT6DwtL6WS1tVsa-wB6-pUL2rjoRTwISYV-XTWx_eI_lw_94u-RBuPYyCXt9l" alt="Instituto de Investigaciones de la Amazonía Peruana">
        <div class="header-title">
            Instituto de Investigaciones de la Amazonía Peruana
        </div>
    </div>

    <p>Hola {{ $alumno->nombre }},</p>

    <p>Adjunto encontrarás tu certificado correspondiente al Evento/curso "{{ $alumno->curso->nombre ?? 'Curso no especificado' }}".</p>

    <p>Gracias por participar.</p>

    <p>Saludos,<br>
    Equipo organizador</p>
</body>
</html>
