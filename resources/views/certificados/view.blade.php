@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-4xl font-bold mb-6 text-center">Vista del Certificado</h1>

    <!-- Contenedor para el canvas -->
    <div id="pdf-container" class="flex justify-center">
        <canvas id="pdf-canvas" class="border border-gray-300 shadow-lg"></canvas>
    </div>

    <div class="flex justify-center mt-4">
        <a href="{{ route('certificados.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Volver a la lista</a>
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
