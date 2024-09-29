@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-4xl font-bold mb-6 text-center">Configuración de Certificados</h1>

    <!-- Muestra los mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla de certificados con configuraciones -->
    <table class="table-auto w-full mb-6">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Certificado</th>
                <th class="px-4 py-2">Posición X</th>
                <th class="px-4 py-2">Posición Y</th>
                <th class="px-4 py-2">Fuente</th>
                <th class="px-4 py-2">Tamaño de Fuente</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($certificados as $certificado)
    <tr class="bg-white">
        <td class="border px-4 py-2">{{ $certificado->nombre }}</td>
        <td class="border px-4 py-2">{{ $certificado->configuracion->pos_x ?? 'N/A' }}</td>
        <td class="border px-4 py-2">{{ $certificado->configuracion->pos_y ?? 'N/A' }}</td>
        <td class="border px-4 py-2">{{ $certificado->configuracion->fuente ?? 'N/A' }}</td>
        <td class="border px-4 py-2">{{ $certificado->configuracion->tamaño_fuente ?? 'N/A' }}</td>
        <td class="border px-4 py-2">
            <a href="{{ route('configuracion.editarconfiguracion', $certificado->id) }}" class="bg-blue-500 text-white py-1 px-2 rounded">Editar</a>
        </td>


    </tr>
@endforeach

        </tbody>
    </table>
</div>
@endsection
