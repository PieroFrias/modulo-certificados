@extends('layouts.app')
<title>Enviar</title>
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
         <!-- Mostrar el número de certificados importados -->
         <div class="mb-4 text-gray-800 font-semibold text-center">
            Certificados ENVIADOS: <span class="text-blue-600">{{ $cantidadFaltantes }}</span>
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
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center gap-2"
                        @if ($cantidadFaltantes > 200) disabled @endif>
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


                <form action="{{ route('curso.reenviarFaltantes', $idcurso) }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 13.5h-2v-2h2Zm0-4h-2v-6h2Z" />
                        </svg>
                        Reenviar Faltantes
                    </button>
                </form>

                {{-- @if (isset($cantidadFaltantes) && $cantidadFaltantes > 150) --}}
                <button
                    class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 flex items-center gap-2"
                    onclick="abrirModalConfiguracion()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 13.5h-2v-2h2Zm0-4h-2v-6h2Z" />
                    </svg>
                    Configurar Reenvío
                </button>
            {{-- @endif --}}
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
        <form action="{{ route('curso.importaralumnos', $idcurso) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="certificados" class="block text-sm sm:text-lg font-medium text-gray-800 mb-2">
                    Subir archivo ZIP con certificados firmados:
                </label>
                <input
                    type="file"
                    id="certificados"
                    name="certificados"
                    accept=".zip,.rar,.7z,.tar,.gz"
                    class="w-full px-4 py-2 rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm"
                    required>
            </div>
            <div class="flex justify-end space-x-4">
                <button
                    type="button"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition"
                    onclick="cerrarModal()">
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    Subir
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalConfiguracion" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="p-6 sm:p-8 rounded-lg shadow-lg w-11/12 max-w-md sm:max-w-lg bg-white border">
        <h2 class="text-lg sm:text-2xl font-bold mb-4 text-center">Configurar Cantidad de Correos a Enviar</h2>
        <form action="{{ route('curso.reenviarFaltantesConfigurados', $idcurso) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="cantidad" class="block text-sm font-medium text-gray-800 mb-2">
                    Cantidad de correos a enviar:
                </label>
                <input
                    type="number"
                    id="cantidad"
                    name="cantidad"
                    min="1"
                    class="w-full px-4 py-2 rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm"
                    required>
            </div>
            <div class="flex justify-end space-x-4">
                <button
                    type="button"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition"
                    onclick="cerrarModalConfiguracion()">
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para mostrar errores -->
@if (session('error'))
<div id="errorModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-11/12 max-w-lg border-black" style="border: 4px solid black;">
        <h2 class="text-lg font-bold text-red-600 mb-4">Errores detectados</h2>
        <p class="text-gray-700">{{ session('error') }}</p>
        <div class="mt-4 text-right">
            <button
                onclick="cerrarErrorModal()"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Cerrar
            </button>
        </div>
    </div>
</div>
@endif






<script>
    function abrirModal() {
        const modal = document.getElementById('importModal');
        modal.classList.remove('hidden');
    }

    function cerrarModal() {
        const modal = document.getElementById('importModal');
        modal.classList.add('hidden');
    }

    function abrirModalConfiguracion() {
    document.getElementById('modalConfiguracion').classList.remove('hidden');
}

function cerrarModalConfiguracion() {
    document.getElementById('modalConfiguracion').classList.add('hidden');
}


function cerrarErrorModal() {
        document.getElementById('errorModal').classList.add('hidden');
    }


</script>

@endsection
