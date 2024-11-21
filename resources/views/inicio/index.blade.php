<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    @vite('resources/css/app.css')
    <style>
        /* Estilo base para el fondo y el contenedor */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 2rem;
        }

        /* Estilo para las tarjetas estilo Pinterest */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(208px, 1fr));
            gap: 1.5rem;
        }

        .card {
            position: relative;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Estilo de los iconos dentro de las tarjetas */
        .card-icon {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 50%;
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60px;
            height: 60px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-icon svg {
            width: 30px;
            height: 30px;
            color: #333;
        }

        .card-content {
            padding: 0.5rem;
            text-align: center;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffa500;
            margin-bottom: 1rem;
        }

        .card-description {
            font-size: 1rem;
            color: #008080;
        }

        /* Agregar un pequeño margen al pie de cada tarjeta */
        .card-footer {
            padding: 1rem;
            background-color: #f9f9f9;
            text-align: center;
            border-top: 1px solid #eee;
        }

        /* Estilos de los botones */
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #008000;
        }

       
        /* Media Queries para Responsividad */

        /* Para pantallas pequeñas */
        @media (max-width: 400px) {
            h1 {
                font-size: 2rem;
            }

            /* Ajustar las tarjetas en pantallas más pequeñas */
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                gap: 1rem;
            }

            .card {
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            /* Asegurarse que las tarjetas no sean demasiado grandes */
            .card-content {
                padding: 1rem;
            }
        }

        /* Para pantallas más pequeñas, como móviles */
        @media (max-width: 468px) {
            .grid {
                grid-template-columns: 1fr; /* Poner una tarjeta por fila */
                gap: 1rem;
            }

            .card {
                width: 100%;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .card-icon {
                width: 50px;
                height: 50px;
            }

            .card-icon svg {
                width: 24px;
                height: 24px;
            }

            .card-title {
                font-size: 1.2rem;
            }

            .card-description {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Panel de Administración</h1>

        <!-- Grid de tarjetas al estilo Pinterest -->
        <div class="grid">
            <!-- Tarjeta Cursos -->
            <div class="card">
                <div class="card-icon bg-blue-200">
                    <svg class="h-10 w-10 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7h20L12 2z" />
                        <path d="M2 9v11a1 1 0 001 1h4v-9h10v9h4a1 1 0 001-1V9H2z" />
                    </svg>
                </div>
                <div class="card-content">
                    <div class="card-title">Cursos</div>
                    <div class="card-description">Gestiona todos los cursos ofrecidos en la plataforma.</div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('curso.index') }}" class="btn">Ir a Cursos</a>
                </div>
            </div>

            <!-- Tarjeta Alumnos -->
            <div class="card">
                <div class="card-icon bg-green-200">
                    <svg class="h-10 w-10 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z" />
                        <path d="M6 20v-1c0-2.67 5.33-4 6-4s6 1.33 6 4v1H6z" />
                    </svg>
                </div>
                <div class="card-content">
                    <div class="card-title">Alumnos</div>
                    <div class="card-description">Visualiza y gestiona a los alumnos registrados.</div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('alumno.index') }}" class="btn">Ir a Alumnos</a>
                </div>
            </div>

            <!-- Tarjeta Certificados -->
            <div class="card">
                <div class="card-icon bg-purple-200">
                    <svg class="h-10 w-10 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z" />
                    </svg>
                </div>
                <div class="card-content">
                    <div class="card-title">Certificados</div>
                    <div class="card-description">Genera y gestiona los certificados de los alumnos.</div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('certificados.index') }}" class="btn">Ir a Certificados</a>
                </div>
            </div>

            <!-- Tarjeta Consulta Generar Certificado -->
            <div class="card">
                <div class="card-icon bg-indigo-200">
                    <svg class="h-10 w-10 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M10 2a8 8 0 105.293 14.293l5.707 5.707a1 1 0 01-1.414 1.414l-5.707-5.707A8 8 0 1010 2zm0 2a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="card-content">
                    <div class="card-title">Consulta Generar Certificado</div>
                    <div class="card-description">Consulta y genera certificados según las necesidades.</div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('consulta.index') }}" class="btn">Ir a Consulta</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>



