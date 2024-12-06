@extends('layouts.app')
<title>Crear</title>
@section('content')
<div class="relative h-screen rounded-lg bg-gray-50">

    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('alumno.index') }}" class="text-blue-500 hover:underline">Personas</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Agregar Persona</li>
        </ol>
    </nav>

    <div class="flex justify-center items-center h-full">
        <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-md mx-auto">

            <h1 class="text-4xl font-semibold mb-6 text-center text-gray-800">Agregar Nueva Persona </h1>

            {{-- <div class="flex justify-center mb-4">
                <a href="{{ route('alumno.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Volver a la Lista de Personas</a>
            </div> --}}

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('alumno.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Alumno</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                </div>

                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido del Alumno</label>
                    <input type="text" name="apellido" id="apellido" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                </div>

                <div>
                    <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                    <input type="number" name="dni" id="dni" maxlength="15" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                </div>

                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Ingrese el correo del alumno" required>
                </div>


                <div>
                    <label for="idcurso" class="block text-sm font-medium text-gray-700">Curso</label>
                    <select name="idcurso" id="idcurso" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="" disabled selected>Seleccione un Curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->idcurso }}">{{ $curso->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Crear Alumno</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
