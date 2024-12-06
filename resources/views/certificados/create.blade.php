<!-- resources/views/certificados/create.blade.php -->
@extends('layouts.app')
<title>Crear</title>
@section('content')
<div class="relative h-screen rounded-lg bg-gray-50">

    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('certificados.index') }}" class="text-blue-500 hover:underline">Plantillas</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Subir Plantilla</li>
        </ol>
    </nav>

    <div class="flex justify-center items-center h-full">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md mx-auto" style="margin-top: -150px;">
            <h1 class="text-2xl font-semibold mb-6 text-center text-gray-800">Subir Plantilla de Certificado</h1>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg mb-6 shadow-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('certificados.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="relative">
                    <label for="nombre" class="block text-sm font-medium text-gray-600 mb-1">Nombre de la Plantilla</label>
                    <input type="text" name="nombre" id="nombre"
                        class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-800 bg-gray-50 px-4 py-2 transition"
                        placeholder="Escribe el nombre del certificado" required>
                </div>

                <div class="relative">
                    <label for="template" class="block text-sm font-medium text-gray-600 mb-1">Subir Plantilla PDF</label>
                    <input type="file" name="template" id="template"
                        class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-800 bg-gray-50 px-4 py-2 transition"
                        accept="application/pdf" required>
                </div>

                <!-- Botón de Enviar -->
                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-blue-600 text-white font-medium py-2 px-6 rounded-lg hover:bg-blue-700 shadow-md transition transform hover:scale-105">
                         Enviar Plantilla
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
