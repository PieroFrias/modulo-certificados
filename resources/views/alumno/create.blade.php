@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-6xl w-full mx-auto">
        <h1 class="text-4xl font-bold mb-6 text-center text-gray-800">Crear Nuevo Alumno</h1>

        <div class="flex justify-center mb-4">
            <a href="{{ route('alumno.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Volver a la Lista de Alumnos</a>
        </div>

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
                <input type="text" name="dni" id="dni" maxlength="15" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
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
@endsection
