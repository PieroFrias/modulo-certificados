@extends('layouts.app') <!-- Asegúrate de que extienda el layout correspondiente -->

@section('content')

<div class="pdf-container" style="width: 100%; overflow-x: auto; margin: 20px auto; position: relative;">
    <!-- Contenedor del PDF -->
    <canvas id="pdfCanvas" style="border: 1px solid #ddd; display: block; margin: 0 auto;"></canvas>
</div>

<div class="button-container mb-5 flex justify-center">
    <a href="{{ route('consulta.index') }}" class="btn btn-primary text-white bg-blue-500 hover:bg-blue-700 px-4 py-2 rounded">
        Regresar al Índice
    </a>
</div>

<!-- Scripts necesarios para PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script>
    // Decodificar el PDF base64
    const pdfData = atob("{{ $pdfBase64 }}");

    // Inicializar la librería PDF.js
    const pdfjsLib = window['pdfjs-dist/build/pdf'];

    // Obtener el canvas y su contexto
    const canvas = document.getElementById('pdfCanvas');
    const context = canvas.getContext('2d');

    // Renderizar el PDF
    pdfjsLib.getDocument({ data: pdfData }).promise.then((pdf) => {
        // Cargar la primera página del PDF
        pdf.getPage(1).then((page) => {
            // Obtener el tamaño del viewport con escala
            const viewport = page.getViewport({ scale: 1 }); // Ajusta el valor de escala si es necesario

            // Mantener la relación de aspecto
            const aspectRatio = viewport.width / viewport.height;

            // Ajustar dinámicamente el tamaño del canvas sin deformarlo
            canvas.width = viewport.width;
            canvas.height = viewport.height;

            // Renderizar la página en el canvas
            const renderContext = {
                canvasContext: context,
                viewport: viewport,
            };
            page.render(renderContext);
        });
    }).catch((error) => {
        console.error('Error al cargar el PDF:', error);
    });
</script>

<style>
    /* Estilos responsivos para permitir el desplazamiento horizontal */
    .pdf-container {
        max-width: 100%;
        overflow-x: auto;
    }

    canvas {
        display: block;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .pdf-container {
            padding: 10px;
        }
    }
</style>

@endsection
