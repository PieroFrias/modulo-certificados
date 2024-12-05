@extends('layouts.app')

@section('content')

<div class="relative min-h-screen bg-gray-50">

    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('curso.index') }}" class="text-blue-500 hover:underline">Eventos - cursos</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Enviar certificados</li>
        </ol>
    </nav>

    <div class="bg-white shadow-lg rounded-lg p-4 sm:p-8 w-full max-w-6xl mx-auto mt-8">
        <br>
        <h1 class="text-2xl sm:text-4xl font-semibold mb-8 text-center text-gray-800">
            Lista de certificados firmados: {{ $curso->nombre }}
        </h1>

        <!-- Mostrar el número de certificados importados -->
        <div class="mb-4 text-gray-800 font-semibold text-center">
            Certificados importados: <span class="text-blue-600">{{ $contadorCertificados }}</span>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-between mb-4 space-y-2 sm:space-y-0">
            <!-- Izquierda: Botones -->
            <div class="flex gap-2">
                <button
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 flex items-center gap-2"
                    onclick="abrirModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06l-3.22-3.22V16.5a.75.75 0 0 1-1.5 0V4.81L8.03 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5ZM3 15.75a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                    Importar certificados firmados
                </button>
                <form action="{{ route('curso.enviarTodosCertificados', $idcurso) }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                        </svg>
                        Enviar todos los certificados
                    </button>
                </form>
            </div>

            <!-- Derecha: Barra de búsqueda y botones -->
            <div class="flex gap-2">
                <form action="{{ route('curso.enviarcertificado', $idcurso) }}" method="GET" class="flex items-center gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Buscar por nombre, apellido, DNI, correo o código"
                        class="w-full sm:w-auto px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm"
                    />
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                        Buscar
                    </button>
                </form>
                <form action="{{ route('curso.enviarcertificado', $idcurso) }}" method="GET" class="flex items-center gap-2">
                    <button
                        type="submit"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition">
                        Limpiar
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md overflow-x-auto">
            @if ($alumnosFirmados->isEmpty())
                <p class="text-gray-500 text-center">No hay certificados firmados.</p>
            @else
            <table class="min-w-full bg-white border border-gray-300 text-sm sm:text-xs">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="py-1 px-2">Nombre</th>
                        <th class="py-1 px-2">Apellido</th>
                        <th class="py-1 px-2">DNI</th>
                        <th class="py-1 px-2 max-w-xs truncate">Correo</th>
                        <th class="py-1 px-2">Curso</th>
                        <th class="py-1 px-2">Código certificado</th>
                        <th class="py-1 px-2">Estado</th>
                        <th class="py-1 px-2">Enviado</th>
                        <th class="py-1 px-2">Veces Enviado</th>
                        <th class="py-1 px-2">Última Actualización</th>
                        <th class="py-1 px-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnosFirmados as $alumno)
                        <tr class="border-t hover:bg-gray-100">
                            <td class="py-1 px-2">{{ $alumno->nombre }}</td>
                            <td class="py-1 px-2">{{ $alumno->apellido }}</td>
                            <td class="py-1 px-2">{{ $alumno->dni }}</td>
                            <td class="py-1 px-2 max-w-xs truncate">{{ $alumno->correo ?? 'No asignado' }}</td>
                            <td class="py-1 px-2">{{ $alumno->curso ? $alumno->curso->nombre : 'Sin Curso' }}</td>
                            <td class="py-1 px-2">{{ $alumno->codigo }}</td>
                            <td class="py-1 px-2">
                                <span class="px-2 py-1 rounded-full text-black text-xs font-semibold
                                    {{ $alumno->estado ? 'bg-yellow-300' : 'bg-red-500' }}">
                                    {{ $alumno->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="py-1 px-2 text-center">
                                {{ $alumno->enviado ? '1' : '0' }}
                            </td>
                            <td class="py-1 px-2 text-center">
                                {{ $alumno->vecesenviado }}
                            </td>
                            <td class="py-1 px-2 text-center">
                                {{ $alumno->updated_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="py-1 px-2">
                                <form action="{{ route('curso.enviarCorreoIndividual', [$idcurso, $alumno->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-blue-600 shadow-md flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                            <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                                        </svg>
                                        Enviar correo
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


                <!-- Paginación -->
                <div class="mt-4">
                    {{ $alumnosFirmados->links() }}
                </div>
            @endif
        </div>
    </div>
</div>


<!-- Modal para importar certificados firmados -->
<div id="importModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="p-6 sm:p-8 rounded-lg shadow-lg w-11/12 max-w-md sm:max-w-lg border-4 border-black" style="background-color: #d0d0d0;">
        <h2 class="text-lg sm:text-2xl font-bold mb-4 text-center">Importar Certificados Firmados</h2>
        <form id="importForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="certificados" class="block text-sm sm:text-lg font-medium text-gray-800 mb-2">
                    Subir archivo ZIP con todos los certificados firmados o suba los PDF comprimidos de 1000 en 1000 certificados:
                </label>
                <input
                    type="file"
                    id="certificados"
                    name="certificados"
                    accept=".zip,.rar,.7z,.tar,.gz,.pdf"
                    class="w-full px-4 py-2 rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm"
                    required>
            </div>
            <div id="progressContainer" class="hidden mb-4">
                <p id="progressText" class="text-gray-800 font-semibold text-center">
                    Progreso: <span id="progressValue">0%</span>
                </p>
                <div class="relative w-full h-4 bg-gray-300 rounded">
                    <div id="progressBar" class="absolute h-4 bg-blue-600 rounded" style="width: 0%;"></div>
                </div>
                <p id="filesProcessed" class="text-sm text-gray-700 text-center mt-2">0 de 0 archivos procesados</p>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" id="submitButton" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Subir</button>
                <button type="button" id="doneButton" class="hidden bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700" onclick="cerrarModalYRefrescar()">Hecho</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModal() {
        const modal = document.getElementById('importModal');
        modal.classList.remove('hidden');
    }

    function cerrarModal() {
        const modal = document.getElementById('importModal');
        modal.classList.add('hidden');
    }

    function cerrarModalYRefrescar() {
        cerrarModal();
        window.location.reload(); // Refrescar la página
    }

    document.getElementById('importForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const progressValue = document.getElementById('progressValue');
        const filesProcessed = document.getElementById('filesProcessed');
        const submitButton = document.getElementById('submitButton');
        const doneButton = document.getElementById('doneButton');

        // Ocultar el botón de "Subir"
        submitButton.classList.add('hidden');

        progressContainer.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressValue.textContent = '0%';
        filesProcessed.textContent = '0 de 0 archivos procesados';

        fetch("{{ route('curso.importaralumnos', $idcurso) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const totalFiles = data.totalFiles;
                let processed = 0;

                // Actualizar el progreso dinámicamente
                const interval = setInterval(() => {
                    if (processed < data.processedFiles) {
                        processed++;
                        const progressPercent = Math.round((processed / totalFiles) * 100);
                        progressBar.style.width = `${progressPercent}%`;
                        progressValue.textContent = `${progressPercent}%`;
                        filesProcessed.textContent = `${processed} de ${totalFiles} archivos procesados`;
                    } else {
                        clearInterval(interval);
                        doneButton.classList.remove('hidden'); // Mostrar el botón "Hecho" al terminar
                    }
                }, 500); // Simular cada archivo como procesado en 500ms
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error durante la importación.');
        });
    });
</script>


@endsection
