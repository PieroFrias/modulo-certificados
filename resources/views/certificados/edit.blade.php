@extends('layouts.app')

@section('content')
<div class="relative h-screen rounded-lg bg-gray-50 flex overflow-x-auto">

    <!-- Nav -->
    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('certificados.index') }}" class="text-blue-500 hover:underline">Plantillas</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Editar Plantilla</li>
        </ol>
    </nav>

    <!-- Panel de Opciones -->
    <div class="bg-white rounded-lg w-1/4 min-w-[300px] p-6 shadow-md">
        <br>
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Opciones de Edición</h2>

        <!-- Mostrar mensaje de error general -->
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg mb-6 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('certificados.update', $certificado->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Campo Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-600 mb-1">Nombre de la Plantilla</label>
                <input type="text" name="nombre" id="nombre" value="{{ $certificado->nombre }}"
                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 text-gray-800 bg-gray-50 transition" required>
                @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Cambiar Plantilla -->
            <div>
                <label for="template" class="block text-sm font-medium text-gray-600 mb-1">Cambiar Plantilla PDF</label>
                <input type="file" name="template" id="template"
                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 text-gray-800 bg-gray-50 transition" accept="application/pdf">
             
            </div>

            <!-- Botón de Actualizar -->
            <div class="flex justify-start">
                <button type="submit"
                    class="bg-blue-600 text-white font-medium py-2 px-6 rounded-lg hover:bg-blue-700 shadow-md transition transform hover:scale-105">
                    Actualizar Plantilla
                </button>
            </div>
        </form>
    </div>

    <!-- Visor PDF -->
    <div class="flex-1 p-6 min-w-[600px]">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Vista Previa de la Plantilla PDF</h2>
        <div id="pdf-viewer" class="border rounded-lg shadow-md overflow-hidden w-full h-[calc(100%-32px)]">
            <!-- Contenedor para PDF.js -->
        </div>
    </div>
</div>



<!-- PDF.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>
<script>
    const url = "{{ asset('storage/certificados/' . $certificado->template) }}"; // Ruta del archivo PDF
    const pdfjsLib = window['pdfjs-dist/build/pdf'];

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.worker.min.js';

    const pdfViewer = document.getElementById('pdf-viewer');

    const renderPDF = async (url) => {
        const pdf = await pdfjsLib.getDocument(url).promise;
        const page = await pdf.getPage(1); // Renderizar solo la primera página

        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        const viewport = page.getViewport({ scale: 0.9 }); // Ajustar escala para que se vea mejor

        canvas.width = viewport.width;
        canvas.height = viewport.height;
        pdfViewer.innerHTML = ''; // Limpiar contenido previo
        pdfViewer.appendChild(canvas);

        const renderContext = {
            canvasContext: context,
            viewport: viewport,
        };

        await page.render(renderContext).promise;
    };

    renderPDF(url);
</script>
@endsection
