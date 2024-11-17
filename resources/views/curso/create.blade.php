@extends('layouts.app')

@section('content')
<div class="relative h-screen rounded-lg bg-gray-50">

     <!-- Breadcrumb fijo -->
     <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('curso.index') }}" class="text-blue-500 hover:underline">Eventos - cursos</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Crear Evento - Curso</li>
        </ol>
    </nav>

     <!-- Contenedor centrado -->
     <div class="flex justify-center items-center h-full">
        <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-md mx-auto">

        <div class="flex justify-start mb-4">
            <!-- Botón con ícono dentro de un círculo -->
            <a href="{{ route('curso.index') }}" class="bg-blue-500 text-white rounded-full p-3 shadow-md hover:bg-blue-600 transition duration-200 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5l-6-6m0 0l6-6m-6 6h15" />
                </svg>
            </a>
        </div>


        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Crear Nuevo Evento - Curso</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 shadow">
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('curso.store') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Campo Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Evento - Curso</label>
                <input type="text" name="nombre" id="nombre"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-700"
                    placeholder="Ingrese el nombre del curso" required>
            </div>

            <!-- Campo Certificado -->
            <div>
                <label for="idcertificado" class="block text-sm font-medium text-gray-700 mb-1">Certificado Vinculado</label>
                <select name="idcertificado" id="idcertificado"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-700"
                    required>
                    <option value="" disabled selected>Seleccione un Certificado</option>
                    @foreach($certificados as $certificado)
                        <option value="{{ $certificado->id }}">{{ $certificado->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Campo Estado -->
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado" id="estado"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-700"
                    required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <!-- Botón Crear -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg hover:bg-blue-700 shadow-lg transition duration-200 transform hover:scale-105">
                    Crear Curso
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
