@extends('layouts.app')

@section('content')
<div class="relative h-screen rounded-lg bg-gray-50 flex flex-col overflow-x-auto">
    <!-- Nav -->
    <nav class="absolute top-0 left-0 px-6 py-4 text-sm text-gray-500 z-10 bg-gray-50 w-full">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('certificados.index') }}" class="text-blue-500 hover:underline">Plantillas</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('configuracion.configuracioncertificado') }}" class="text-blue-500 hover:underline">Personalisar Plantilla</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Plantilla</li>
        </ol>
    </nav>

    <!-- Contenedor Principal con padding-top -->
    <div class="pt-16 flex w-full"> <!-- Cambiado de mt-20 a pt-16 -->
        <!-- Formulario de Configuración -->
        <div class="w-1/4 bg-gray-100 p-4 rounded shadow-md">
            <form id="form-configuracion" action="{{ route('configuracion.update', $certificado->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Título del Formulario -->
                <h2 class="text-lg font-semibold text-gray-700">Configuración</h2>

                <!-- Selección de Fuente -->
                <div class="form-group">
                    <label for="fuente" class="block text-sm font-medium text-gray-700">Fuente:</label>
                    <select name="fuente" id="fuente" class="form-control w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="Arial" {{ $configuracion->fuente == 'Arial' ? 'selected' : '' }}>Arial</option>
                        <option value="Helvetica" {{ $configuracion->fuente == 'Helvetica' ? 'selected' : '' }}>Helvetica</option>
                        <option value="Times" {{ $configuracion->fuente == 'Times' ? 'selected' : '' }}>Times New Roman</option>
                        <option value="Georgia" {{ $configuracion->fuente == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                        <option value="Garamond" {{ $configuracion->fuente == 'Garamond' ? 'selected' : '' }}>Garamond</option>
                        <option value="Brush Script MT" {{ $configuracion->fuente == 'Brush Script MT' ? 'selected' : '' }}>Brush Script MT</option>
                        <option value="Palatino Linotype" {{ $configuracion->fuente == 'Palatino Linotype' ? 'selected' : '' }}>Palatino Linotype</option>
                        <option value="Perpetua" {{ $configuracion->fuente == 'Perpetua' ? 'selected' : '' }}>Perpetua</option>
                    </select>
                </div>

                <!-- Tamaño de Fuente -->
                <div class="form-group">
                    <label for="tamaño_fuente" class="block text-sm font-medium text-gray-700">Tamaño:</label>
                    <input type="number" name="tamaño_fuente" id="tamaño_fuente" value="{{ $configuracion->tamaño_fuente }}" class="form-control w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-300" min="8" max="72">
                </div>

                <!-- Botón para guardar cambios -->
                <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-400 focus:ring focus:ring-blue-300">
                    Guardar
                </button>

                <!-- Coordenadas ocultas -->
                <input type="hidden" name="pos_x" id="input_pos_x" value="{{ $configuracion->pos_x }}">
                <input type="hidden" name="pos_y" id="input_pos_y" value="{{ $configuracion->pos_y }}">
            </form>
        </div>

        <!-- Contenedor del Certificado -->
        <div class="w-3/4">
            <div class="pdf-container relative">
                <canvas id="pdf-render" class="border border-gray-300"></canvas> <!-- Certificado Renderizado -->
                <p id="pdf-dimensions" class="text-center mt-2"></p> <!-- Dimensiones del PDF -->

                <!-- Elementos Arrastrables -->
                <div id="draggable-container" style="position: absolute; top: 0; left: 0;">
                    <div id="nombre" class="draggable" style="position: absolute; top: {{ $configuracion->pos_y }}px; left: {{ $configuracion->pos_x }}px; background-color: transparent; border: none;">
                        N
                    </div>
                </div>
                <p id="coords" class="text-center mt-2"></p> <!-- Mostrar Coordenadas -->
            </div>
        </div>
    </div>
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
    const fuenteSelect = document.getElementById('fuente');
    const tamañoFuenteInput = document.getElementById('tamaño_fuente');

    const A4_WIDTH_MM = 210; // Ancho A4 en mm
    const A4_HEIGHT_MM = 297; // Alto A4 en mm
    const MM_TO_PX = 3.7795275591; // Conversión de mm a píxeles

    // Crear las líneas vertical y horizontal
    const verticalLine = document.createElement('div');
    verticalLine.id = 'vertical-line';
    verticalLine.style.position = 'absolute';
    verticalLine.style.width = '1px';
    verticalLine.style.height = '100%';
    verticalLine.style.backgroundColor = 'red';
    verticalLine.style.display = 'none';
    verticalLine.style.zIndex = '100';
    draggableContainer.appendChild(verticalLine);

    const horizontalLine = document.createElement('div');
    horizontalLine.id = 'horizontal-line';
    horizontalLine.style.position = 'absolute';
    horizontalLine.style.height = '1px';
    horizontalLine.style.width = '100%';
    horizontalLine.style.backgroundColor = 'red';
    horizontalLine.style.display = 'none';
    horizontalLine.style.zIndex = '100';
    draggableContainer.appendChild(horizontalLine);

    // Mostrar las líneas al centrar el elemento
    const toggleLines = () => {
        const canvasRect = canvas.getBoundingClientRect();
        const draggableRect = draggable.getBoundingClientRect();

        // Coordenadas del centro del canvas
        const canvasCenterX = canvasRect.left + canvasRect.width / 2;
        const canvasCenterY = canvasRect.top + canvasRect.height / 2;

        // Coordenadas del centro del elemento draggable
        const draggableCenterX = draggableRect.left + draggableRect.width / 2;
        const draggableCenterY = draggableRect.top + draggableRect.height / 2;

        // Mostrar la línea vertical si el centro horizontal está alineado
        if (Math.abs(canvasCenterX - draggableCenterX) < 2) { // Umbral de 2px
            verticalLine.style.left = `${canvasRect.width / 2}px`;
            verticalLine.style.display = 'block';
        } else {
            verticalLine.style.display = 'none';
        }

        // Mostrar la línea horizontal si el centro vertical está alineado
        if (Math.abs(canvasCenterY - draggableCenterY) < 2) { // Umbral de 2px
            horizontalLine.style.top = `${canvasRect.height / 2}px`;
            horizontalLine.style.display = 'block';
        } else {
            horizontalLine.style.display = 'none';
        }
    };

    let pdfDoc = null,
        pageNum = 1,
        dragging = false,
        scale = 1; // Variable para mantener la escala

    // Convertir milímetros a píxeles
    const mmToPx = (mm) => mm * MM_TO_PX;

    // Renderizar página del PDF ajustándola al tamaño A4, manteniendo la proporción y centrando
    const renderPage = (num) => {
        pdfDoc.getPage(num).then((page) => {
            const originalViewport = page.getViewport({ scale: 1 });
            const isLandscape = originalViewport.width > originalViewport.height;

            let canvasWidth = isLandscape ? A4_HEIGHT_MM * MM_TO_PX : A4_WIDTH_MM * MM_TO_PX;
            let canvasHeight = isLandscape ? A4_WIDTH_MM * MM_TO_PX : A4_HEIGHT_MM * MM_TO_PX;

            scale = Math.min(canvasWidth / originalViewport.width, canvasHeight / originalViewport.height);
            const viewport = page.getViewport({ scale });

            canvas.width = canvasWidth;
            canvas.height = canvasHeight;

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext).promise.then(() => {
                draggableContainer.style.width = `${canvasWidth}px`;
                draggableContainer.style.height = `${canvasHeight}px`;

                pdfDimensions.innerText = `Tamaño del PDF ajustado a A4: ${A4_WIDTH_MM} mm de ancho por ${A4_HEIGHT_MM} mm de alto`;

                const posXmm = parseFloat(document.getElementById('input_pos_x').value);
                const posYmm = parseFloat(document.getElementById('input_pos_y').value);

                const posXpx = mmToPx(posXmm);
                const posYpx = mmToPx(posYmm);

                draggable.style.position = 'absolute';
                draggable.style.left = `${posXpx}px`;
                draggable.style.textAlign = 'center';  // Alinea el texto en el centro
                draggable.style.top = `${posYpx}px`;
                draggable.style.display = 'block';
            });
        });
    };

    pdfjsLib.getDocument(url).promise.then((pdfDoc_) => {
        pdfDoc = pdfDoc_;
        renderPage(pageNum);
    });

    window.addEventListener('load', () => {
        draggable.style.fontFamily = fuenteSelect.value;
        draggable.style.fontSize = `${tamañoFuenteInput.value}px`;
    });

    draggable.addEventListener('mousedown', function (event) {
        event.preventDefault();
        dragging = true;

        let offsetX = event.clientX - parseInt(window.getComputedStyle(this).left);
        let offsetY = event.clientY - parseInt(window.getComputedStyle(this).top);

        function mouseMoveHandler(e) {
            if (!dragging) return;

            let newX = e.clientX - offsetX;
            let newY = e.clientY - offsetY;

            const canvasRect = canvas.getBoundingClientRect();
            if (newX < 0) newX = 0;
            if (newY < 0) newY = 0;
            if (newX > canvasRect.width - draggable.offsetWidth) newX = canvasRect.width - draggable.offsetWidth;
            if (newY > canvasRect.height - draggable.offsetHeight) newY = canvasRect.height - draggable.offsetHeight;

            draggable.style.left = `${newX}px`;
            draggable.style.top = `${newY}px`;

            const posXmm = (newX / MM_TO_PX).toFixed(2);
            const posYmm = (newY / MM_TO_PX).toFixed(2);
            coordsDisplay.innerText = `Posición actual: X: ${posXmm} mm, Y: ${posYmm} mm`;

            document.getElementById('input_pos_x').value = posXmm;
            document.getElementById('input_pos_y').value = posYmm;

            toggleLines();
        }

        document.addEventListener('mousemove', mouseMoveHandler);
        document.addEventListener('mouseup', function () {
            dragging = false;
            document.removeEventListener('mousemove', mouseMoveHandler);
            verticalLine.style.display = 'none';
            horizontalLine.style.display = 'none';
        });
    });

    fuenteSelect.addEventListener('change', () => {
        draggable.style.fontFamily = fuenteSelect.value;
    });

    tamañoFuenteInput.addEventListener('input', () => {
        draggable.style.fontSize = `${tamañoFuenteInput.value}px`;
    });
</script>


<style>

    #draggable-container {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 5; /* Ajustar el índice z para asegurar que el formulario tenga prioridad */
    }
    .draggable {
    background-color: black;
    padding: 1px;
    cursor: move;
    position: absolute;
    font-size: 1px;
    font-family: Arial, sans-serif;
    user-select: none; /* Evitar selección de texto */
    -webkit-user-select: none; /* Para Safari */
    -moz-user-select: none; /* Para Firefox */
    -ms-user-select: none; /* Para IE/Edge */
}

    form {
        position: relative;
        z-index: 10; /* Asegurar que los campos del formulario tengan prioridad sobre el área arrastrable */
    }

</style>
@endsection
