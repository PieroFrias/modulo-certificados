@extends('layouts.app') <!-- Asegúrate de que extienda el layout correspondiente si lo usas -->

@section('content')

<div class="pdf-container" style="width: 80%; height: 80vh; margin: 20px auto;">
    <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}" type="application/pdf" style="width: 100%; height: 100%; border: none;"></iframe>
</div>

<div class="button-container mb-5 flex justify-center">
    <a href="{{ route('consulta.index') }}" class="btn btn-primary text-white bg-blue-500 hover:bg-blue-700 px-4 py-2 rounded">
        Regresar al Índice
    </a>
</div>
@endsection







{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-4xl font-bold mb-6 text-center">Vista del Certificado de {{ $alumno->nombre }} {{ $alumno->apellido }}</h1>

    <!-- Mostrar el PDF y las medidas -->
    <div class="pdf-container" style="position: relative;" id="pdf-container">
        <canvas id="pdf-render" style="border: 1px solid black; width: 100%;"></canvas>
        <p id="pdf-dimensions" class="text-center mt-2"></p> <!-- Mostrar dimensiones del PDF -->

        <!-- Elementos arrastrables -->
        <div id="draggable-container" style="position: absolute; top: 0; left: 0;">
            <div id="nombre" class="draggable" style="position: absolute; top: {{ $configuracion->pos_y }}mm; left: {{ $configuracion->pos_x }}mm; background-color: white; border: none; font-family: {{ $configuracion->fuente }}; font-size: {{ $configuracion->tamaño_fuente }}px;">
                {{ $alumno->nombre }} {{ $alumno->apellido }}
            </div>
        </div>
    </div>

    <!-- Botón para descargar el PDF -->
    <div class="text-center mt-6">
        <button id="download-pdf" class="bg-blue-500 text-white py-2 px-4 rounded">Descargar PDF</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const url = "{{ $pdfUrl }}"; // Ruta del PDF que se pasa desde el controlador

        const canvas = document.getElementById('pdf-render');
        const ctx = canvas.getContext('2d');
        const pdfDimensions = document.getElementById('pdf-dimensions'); // Elemento para las dimensiones
        const draggableContainer = document.getElementById('draggable-container'); // Contenedor del draggable

        let pdfDoc = null,
            pageNum = 1,
            scale = 1.5;

        // Convertir puntos a milímetros (1 punto = 0.352778 mm)
        const pointsToMm = (points) => points * 0.352778;

        // Renderizar página del PDF
        const renderPage = (num) => {
            pdfDoc.getPage(num).then((page) => {
                // Obtener el viewport del PDF escalado
                const viewport = page.getViewport({ scale });

                // Convertir dimensiones de puntos a milímetros
                const widthMm = pointsToMm(viewport.width);
                const heightMm = pointsToMm(viewport.height);

                // Ajustar dimensiones del canvas al tamaño del viewport
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                // Mostrar dimensiones del PDF en milímetros
                pdfDimensions.innerText = `Tamaño del PDF: ${widthMm.toFixed(2)} mm de ancho por ${heightMm.toFixed(2)} mm de alto`;

                // Renderizar el PDF en el canvas
                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                page.render(renderContext);

                // Ajustar el contenedor arrastrable a las dimensiones del canvas
                draggableContainer.style.width = `${viewport.width}px`;
                draggableContainer.style.height = `${viewport.height}px`;
            });
        };

        // Obtener el PDF
        pdfjsLib.getDocument(url).promise.then((pdfDoc_) => {
            pdfDoc = pdfDoc_;
            renderPage(pageNum);
        });

        // Descargar el PDF generado a partir de la vista
        document.getElementById('download-pdf').addEventListener('click', () => {
            const { jsPDF } = window.jspdf;

            html2canvas(document.getElementById('pdf-container')).then((canvas) => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [canvas.width * 0.264583, canvas.height * 0.264583] // Convertir píxeles a mm (1 px ≈ 0.264583 mm)
                });

                pdf.addImage(imgData, 'PNG', 0, 0, canvas.width * 0.264583, canvas.height * 0.264583);
                pdf.save('certificado_{{ $alumno->dni }}.pdf');
            });
        });
    </script>
</div>
@endsection --}}

