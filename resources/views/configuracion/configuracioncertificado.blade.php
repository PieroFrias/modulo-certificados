@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold mb-6 text-center">Configuración de Certificados</h1>

    <!-- Muestra los mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla de certificados con configuraciones -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full min-w-max mb-6">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">Certificado</th>
                    <th class="px-4 py-2 text-left">Posición X</th>
                    <th class="px-4 py-2 text-left">Posición Y</th>
                    <th class="px-4 py-2 text-left">Fuente</th>
                    <th class="px-4 py-2 text-left">Tamaño de Fuente</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($certificados as $certificado)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $certificado->nombre }}</td>
                        <td class="border px-4 py-2">{{ $certificado->configuracion->pos_x ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $certificado->configuracion->pos_y ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $certificado->configuracion->fuente ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $certificado->configuracion->tamaño_fuente ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('configuracion.editarconfiguracion', $certificado->id) }}" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-700">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
