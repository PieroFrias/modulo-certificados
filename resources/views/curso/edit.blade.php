@extends('layouts.app')
<title>Editar</title>
@section('content')
<div class="relative h-screen rounded-lg bg-gray-50">
    <!-- Breadcrumb fijo -->
    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('curso.index') }}" class="text-blue-500 hover:underline">Eventos - cursos</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Editar Evento - Curso</li>
        </ol>
    </nav>


    <!-- Contenedor centrado -->
    <div class="flex justify-center items-center h-full">
        <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-md mx-auto">


            {{-- <!-- Botón de regresar con solo un ícono -->
            <div class="flex justify-start mb-6">
                <a href="{{ route('curso.index') }}" class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 shadow-md transition duration-200 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5l-6-6m0 0l6-6m-6 6h15" />
                    </svg>
                </a>
            </div> --}}

            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Editar Evento - Curso</h1>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                    <ul class="list-disc pl-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('curso.update', $curso->idcurso) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Nombre del Curso -->
                <div class="relative mb-6">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Evento - Curso</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $curso->nombre) }}"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-2 bg-gray-50 transition duration-150 ease-in-out"
                        placeholder="Nombre del Curso" required>
                </div>

                <!-- Certificado Vinculado -->
                <div class="relative mb-6">
                    <label for="idcertificado" class="block text-sm font-medium text-gray-700 mb-1">Certificado Vinculado</label>
                    <select name="idcertificado" id="idcertificado"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-2 bg-gray-50 transition duration-150 ease-in-out"
                        required>
                        @foreach($certificados as $certificado)
                            <option value="{{ $certificado->id }}" {{ $curso->idcertificado == $certificado->id ? 'selected' : '' }}>{{ $certificado->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="hora" class="block text-sm font-medium text-gray-700 mb-1">Duracion en Horas del Evento - Curso</label>
                    <input type="number" name="hora" id="hora" min="0"  value="{{ old('hora', $curso->hora) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-700"
                        placeholder="Ingrese las horas" required>
                </div>


                <!-- Estado -->
                <div class="relative mb-6">
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="estado" id="estado"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-2 bg-gray-50 transition duration-150 ease-in-out"
                        required>
                        <option value="1" {{ $curso->estado == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $curso->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <!-- Botón Actualizar -->
                <div class="flex justify-center mt-6">
                    <button type="submit"
                    class="bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg hover:bg-blue-700 shadow-lg transition duration-200 transform hover:scale-105">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
