@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-4xl font-bold mb-6 text-center">Editar Configuración de {{ $certificado->nombre }}</h1>

    <!-- Mostrar el PDF y las medidas -->
    <div class="pdf-container" style="position: relative;">
        <canvas id="pdf-render" style="border: 1px solid black; width: 100%;"></canvas>
        <p id="pdf-dimensions" class="text-center mt-2"></p> <!-- Mostrar dimensiones del PDF -->

        <!-- Elementos arrastrables -->
        <div id="draggable-container" style="position: absolute; top: 0; left: 0;">
            <div id="nombre" class="draggable" style="position: absolute; top: {{ $configuracion->pos_y }}px; left: {{ $configuracion->pos_x }}px;">
                Nombre Apellido
            </div>
        </div>
        <p id="coords" class="text-center mt-2"></p> <!-- Mostrar coordenadas en tiempo real -->
    </div>

    <!-- Formulario para cambiar fuente y tamaño de fuente -->
    <form id="form-configuracion" action="{{ route('configuracion.update', $certificado->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <div class="form-group">
                <label for="fuente" class="block text-sm font-medium text-gray-700">Fuente:</label>
                <select name="fuente" id="fuente" class="form-control block w-full mt-1">
                    <option value="Arial" {{ $configuracion->fuente == 'Arial' ? 'selected' : '' }}>Arial</option>
                    <option value="Helvetica" {{ $configuracion->fuente == 'Helvetica' ? 'selected' : '' }}>Helvetica</option>
                    <option value="Times" {{ $configuracion->fuente == 'Times' ? 'selected' : '' }}>Times New Roman</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tamaño_fuente" class="block text-sm font-medium text-gray-700">Tamaño de la fuente:</label>
                <input type="number" name="tamaño_fuente" id="tamaño_fuente" value="{{ $configuracion->tamaño_fuente }}" class="form-control block w-full mt-1" min="8" max="72">
            </div>

            <!-- Coordenadas ocultas -->
            <input type="hidden" name="pos_x" id="input_pos_x" value="{{ $configuracion->pos_x }}">
            <input type="hidden" name="pos_y" id="input_pos_y" value="{{ $configuracion->pos_y }}">
        </div>

        <!-- Botón para guardar cambios manualmente -->
        <div class="text-right mt-6">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Guardar Cambios</button>
        </div>
    </form>




    <!-- Notificación -->
    <div id="notification" class="mt-4 text-green-500"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script>
    const url = "{{ $pdfUrl }}"; // Ruta del PDF que se pasa desde el controlador

    const canvas = document.getElementById('pdf-render');
    const ctx = canvas.getContext('2d');
    const pdfDimensions = document.getElementById('pdf-dimensions'); // Elemento para las dimensiones
    const coordsDisplay = document.getElementById('coords'); // Elemento para mostrar coordenadas
    const draggable = document.getElementById('nombre'); // Elemento arrastrable
    const draggableContainer = document.getElementById('draggable-container'); // Contenedor del draggable

    let pdfDoc = null,
        pageNum = 1,
        scale = 1.5;

    // Renderizar página del PDF
    const renderPage = (num) => {
        pdfDoc.getPage(num).then((page) => {
            const viewport = page.getViewport({ scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Mostrar dimensiones del PDF
            pdfDimensions.innerText = `Tamaño del PDF: ${viewport.width.toFixed(2)}px de ancho por ${viewport.height.toFixed(2)}px de alto`;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            page.render(renderContext);

            // Ajustar el contenedor arrastrable a las dimensiones del canvas
            draggableContainer.style.width = `${canvas.width}px`;
            draggableContainer.style.height = `${canvas.height}px`;
        });
    };

    // Obtener el PDF
    pdfjsLib.getDocument(url).promise.then((pdfDoc_) => {
        pdfDoc = pdfDoc_;
        renderPage(pageNum);
    });

    // Funcionalidad para arrastrar y soltar con visualización en tiempo real de coordenadas
draggable.addEventListener('mousedown', function(event) {
    let offsetX = event.clientX - parseInt(window.getComputedStyle(this).left);
    let offsetY = event.clientY - parseInt(window.getComputedStyle(this).top);

    function mouseMoveHandler(e) {
        let newX = e.clientX - offsetX;
        let newY = e.clientY - offsetY;

        // Limitar el movimiento dentro del área del canvas (PDF)
        const canvasRect = canvas.getBoundingClientRect();
        if (newX < 0) newX = 0;
        if (newY < 0) newY = 0;
        if (newX > canvas.width - draggable.offsetWidth) newX = canvas.width - draggable.offsetWidth;
        if (newY > canvas.height - draggable.offsetHeight) newY = canvas.height - draggable.offsetHeight;

        draggable.style.left = `${newX}px`;
        draggable.style.top = `${newY}px`;

        // Mostrar coordenadas en tiempo real
        coordsDisplay.innerText = `Posición actual: X: ${parseInt(draggable.style.left)}px, Y: ${parseInt(draggable.style.top)}px`;

        // Actualizar campos ocultos en el formulario
        document.getElementById('input_pos_x').value = parseInt(draggable.style.left);
        document.getElementById('input_pos_y').value = parseInt(draggable.style.top);
    }

    document.addEventListener('mousemove', mouseMoveHandler);
    document.addEventListener('mouseup', function() {
        document.removeEventListener('mousemove', mouseMoveHandler);
    });
});

</script>

<style>
    #draggable-container {
        position: absolute;
        top: 0;
        left: 0;
    }
    .draggable {
        background-color: lightgrey;
        padding: 10px;
        border: 1px solid black;
        cursor: move;
    }
</style>
@endsection
