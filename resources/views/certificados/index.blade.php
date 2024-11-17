@extends('layouts.app')

@section('content')
<div class="relative h-screen rounded-lg bg-gray-50">

    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Plantillas</li>
        </ol>
    </nav>


    <div class="bg-white shadow-md rounded-lg p-6 max-w-6xl w-full mx-auto">
        <br>
        <h1 class="text-4xl font-semibold mb-6 text-center text-gray-800">Plantillas de Certificados</h1>

        <div class="flex justify-start mb-4 space-x-2"> <!-- Justify-start para alinear a la izquierda y espacio entre botones -->
            <a href="{{ route('certificados.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Subir Nuevo Certificado</a>
            <a href="{{ route('configuracion.configuracioncertificado') }}" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Personalizar Certificados</a>
        </div>


        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla Responsiva centrada -->
        <div class="flex justify-center">
            <div class="overflow-x-auto w-full ">
                <table class="min-w-full w-full bg-white border border-gray-300">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-xs sm:text-sm">
                        <tr>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Identificación</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Nombre</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Fecha</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-xs sm:text-sm">
                        @foreach($certificados as $certificado)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $certificado->id }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $certificado->nombre }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $certificado->created_at->format('d/m/Y') }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6 text-center flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <a href="{{ route('certificados.view', $certificado->id) }}" class="bg-blue-500 text-white py-1 px-2 sm:px-3 rounded hover:bg-blue-600 text-xs sm:text-sm">Ver</a>
                                <a href="{{ route('certificados.edit', $certificado->id) }}" class="bg-yellow-500 text-white py-1 px-2 sm:px-3 rounded hover:bg-yellow-600 text-xs sm:text-sm">Editar</a>
                                <form action="{{ route('certificados.destroy', $certificado->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-1 px-2 sm:px-3 rounded hover:bg-red-600 text-xs sm:text-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
