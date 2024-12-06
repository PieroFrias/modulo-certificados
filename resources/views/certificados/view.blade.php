@extends('layouts.app')
<title>Ver</title>
@section('content')
<div class="relative h-screen rounded-lg bg-gray-50 flex overflow-x-auto">

     <!-- Nav -->
     <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('certificados.index') }}" class="text-blue-500 hover:underline">Plantillas</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Ver Plantilla</li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-4 max-w-6xl w-full mx-auto">
        <br>
        <h1 class="text-4xl font-semibold mb-6 text-center">Vista del Certificado</h1>

        <!-- Contenedor para el canvas -->
        <div id="pdf-container" class="flex justify-center">
            <canvas id="pdf-canvas" class="border border-gray-300 shadow-lg rounded-lg"></canvas>
        </div>

        <div class="flex justify-center mt-4">
            <a href="{{ route('certificados.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Volver</a>
        </div>
    </div>
</div>

<!-- PDF.js y Scripts para mostrar el PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"></script>

<script>
    const url = "{{ $url }}";  // Usar la URL pasada desde el controlador

    let pdfDoc = null,
        pageNum = 1,
        canvas = document.getElementById('pdf-canvas'),
        ctx = canvas.getContext('2d'),
        scale = 1.5; // Escala inicial

    // Función para calcular la escala según el tamaño de la pantalla
    function calculateScale(page) {
        const maxWidth = window.innerWidth * 0.9; // 90% del ancho de la pantalla
        const viewport = page.getViewport({ scale: 1 }); // Obtiene el viewport sin escalar

        // Escala para que el ancho del PDF ocupe el 90% del ancho de la ventana
        const scale = maxWidth / viewport.width;

        return scale;
    }

    // Función para renderizar la página
    function renderPage(num) {
        pdfDoc.getPage(num).then(function(page) {
            // Calculamos la escala responsiva
            const responsiveScale = calculateScale(page);

            // Ajusta el viewport según la escala
            let viewport = page.getViewport({ scale: responsiveScale });

            // Ajusta el tamaño del canvas según el viewport
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            let renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext);
        });
    }

    // Cargar el PDF usando PDF.js
    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        renderPage(pageNum);
    });

    // Re-renderizar la página cuando se redimensiona la ventana
    window.addEventListener('resize', function() {
        renderPage(pageNum);
    });
</script>
@endsection
