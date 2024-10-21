@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-6xl w-full mx-auto">
        <h1 class="text-4xl font-bold mb-6 text-center text-gray-800">Editar Curso</h1>

        <div class="flex justify-center mb-4">
            <a href="{{ route('curso.index') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Volver a la Lista de Cursos</a>
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

        <form action="{{ route('curso.update', $curso->idcurso) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Curso</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $curso->nombre) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div>
                <label for="idcertificado" class="block text-sm font-medium text-gray-700">Certificado Vinculado</label>
                <select name="idcertificado" id="idcertificado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    @foreach($certificados as $certificado)
                        <option value="{{ $certificado->id }}" {{ $curso->idcertificado == $certificado->id ? 'selected' : '' }}>{{ $certificado->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="1" {{ $curso->estado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $curso->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Actualizar Curso</button>
            </div>
        </form>
    </div>
</div>
@endsection
