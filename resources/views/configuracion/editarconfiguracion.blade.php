@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-4xl font-bold mb-6 text-center">Editar Configuración de {{ $certificado->nombre }}</h1>

    <!-- Mostrar el PDF y las medidas -->
    <div class="pdf-container" style="position: relative; width: 100%; max-width: 800px; height: auto; margin: 0 auto;">
        <canvas id="pdf-render" style="border: 1px solid black; width: 100%;"></canvas> <!-- Tamaño ajustable según la orientación -->
        <p id="pdf-dimensions" class="text-center mt-2"></p> <!-- Mostrar dimensiones del PDF -->

        <!-- Elementos arrastrables -->
        <div id="draggable-container">
            <div id="nombre" class="draggable" style="position: absolute; top: {{ $configuracion->pos_y }}px; transform: translateX(50%); left: 50%; background-color: transparent; border: none;">
                Nombre
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
                    <option value="Georgia" {{ $configuracion->fuente == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                    <option value="Garamond" {{ $configuracion->fuente == 'Garamond' ? 'selected' : '' }}>Garamond</option>
                    <option value="Brush Script MT" {{ $configuracion->fuente == 'Brush Script MT' ? 'selected' : '' }}>Brush Script MT</option>
                    <option value="Palatino Linotype" {{ $configuracion->fuente == 'Palatino Linotype' ? 'selected' : '' }}>Palatino Linotype</option>
                    <option value="Perpetua" {{ $configuracion->fuente == 'Perpetua' ? 'selected' : '' }}>Perpetua</option>
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
        <div class="text-left mt-6">
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
    const fuenteSelect = document.getElementById('fuente');
    const tamañoFuenteInput = document.getElementById('tamaño_fuente');

    const A4_WIDTH_MM = 210; // Ancho A4 en mm
    const A4_HEIGHT_MM = 297; // Alto A4 en mm
    const MM_TO_PX = 3.7795275591; // Conversión de mm a píxeles

    let pdfDoc = null,
        pageNum = 1,
        dragging = false,
        scale = 1; // Variable para mantener la escala

    // Convertir milímetros a píxeles
    const mmToPx = (mm) => mm * MM_TO_PX;

    // Renderizar página del PDF ajustándola al tamaño A4, manteniendo la proporción y centrando
    const renderPage = (num) => {
        pdfDoc.getPage(num).then((page) => {
            // Crear un viewport escalado para ajustarse al tamaño A4
            const originalViewport = page.getViewport({ scale: 1 });

            // Determinar la orientación del PDF
            const isLandscape = originalViewport.width > originalViewport.height;

            // Definir dimensiones del canvas para A4 en píxeles, tomando en cuenta la orientación
            let canvasWidth = isLandscape ? A4_HEIGHT_MM * MM_TO_PX : A4_WIDTH_MM * MM_TO_PX;
            let canvasHeight = isLandscape ? A4_WIDTH_MM * MM_TO_PX : A4_HEIGHT_MM * MM_TO_PX;

            // Escala para mantener la proporción del PDF ajustándolo al tamaño A4
            scale = Math.min(canvasWidth / originalViewport.width, canvasHeight / originalViewport.height);
            const viewport = page.getViewport({ scale });

            // Ajustar dimensiones del canvas al tamaño A4
            canvas.width = canvasWidth;
            canvas.height = canvasHeight;

            // Limpiar el canvas antes de renderizar
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Renderizar el PDF en el canvas
            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext).promise.then(() => {
                // Ajustar el contenedor arrastrable a las dimensiones del canvas
                draggableContainer.style.width = `${canvasWidth}px`;
                draggableContainer.style.height = `${canvasHeight}px`;

                // Mostrar dimensiones del PDF en milímetros
                pdfDimensions.innerText = `Tamaño del PDF ajustado a A4: ${A4_WIDTH_MM} mm de ancho por ${A4_HEIGHT_MM} mm de alto`;

                // Posicionar el elemento 'draggable' en la posición guardada (en milímetros)
                const posXmm = parseFloat(document.getElementById('input_pos_x').value);
                const posYmm = parseFloat(document.getElementById('input_pos_y').value);
                
                // Convertir las coordenadas de milímetros a píxeles
                const posXpx = mmToPx(posXmm);
                const posYpx = mmToPx(posYmm);

                draggable.style.position = 'absolute';
                draggable.style.left = `${posXpx}px`;
                draggable.style.textAlign = 'center';  // Alinea el texto en el centro
                draggable.style.top = `${posYpx}px`;
                draggable.style.width = 'auto'; // Ajustar ancho al contenido del elemento
                draggable.style.display = 'block'; // Asegurarse de que el elemento sea visible
            });
        });
    };

    // Obtener el PDF
    pdfjsLib.getDocument(url).promise.then((pdfDoc_) => {
        pdfDoc = pdfDoc_;
        renderPage(pageNum);
    });

    // Aplicar fuente, tamaño y posición iniciales al cargar la página
    window.addEventListener('load', () => {
        draggable.style.fontFamily = fuenteSelect.value;
        draggable.style.fontSize = `${tamañoFuenteInput.value}px`;
    });

    // Funcionalidad para arrastrar y soltar con visualización en tiempo real de coordenadas
    draggable.addEventListener('mousedown', function (event) {
        dragging = true;

        let offsetX = event.clientX - parseInt(window.getComputedStyle(this).left);
        let offsetY = event.clientY - parseInt(window.getComputedStyle(this).top);

        function mouseMoveHandler(e) {
            if (!dragging) return;

            let newX = e.clientX - offsetX;
            let newY = e.clientY - offsetY;

            // Limitar el movimiento dentro del área del canvas (PDF)
            const canvasRect = canvas.getBoundingClientRect();
            if (newX < 0) newX = 0;
            if (newY < 0) newY = 0;
            if (newX > canvasRect.width - draggable.offsetWidth) newX = canvasRect.width - draggable.offsetWidth;
            if (newY > canvasRect.height - draggable.offsetHeight) newY = canvasRect.height - draggable.offsetHeight;

            draggable.style.left = `${newX}px`;
            draggable.style.top = `${newY}px`;

            // Mostrar coordenadas en milímetros en tiempo real
            const posXmm = (newX / MM_TO_PX).toFixed(2);
            const posYmm = (newY / MM_TO_PX).toFixed(2);
            coordsDisplay.innerText = `Posición actual: X: ${posXmm} mm, Y: ${posYmm} mm`;

            // Actualizar campos ocultos en el formulario con valores en milímetros
            document.getElementById('input_pos_x').value = posXmm;
            document.getElementById('input_pos_y').value = posYmm;
        }

        document.addEventListener('mousemove', mouseMoveHandler);
        document.addEventListener('mouseup', function () {
            dragging = false;
            document.removeEventListener('mousemove', mouseMoveHandler);
        });
    });

    // Cambiar el tamaño y la fuente del texto en tiempo real
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
        padding: 10px;
        cursor: move;
        position: relative;
        width: auto;
        max-width: 100%;
        font-size: 20px;
        font-family: Arial, sans-serif;
        text-align: center;
    }
    form {
        position: relative;
        z-index: 10; /* Asegurar que los campos del formulario tengan prioridad sobre el área arrastrable */
    }

</style>
@endsection
