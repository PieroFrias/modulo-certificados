@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg w-full mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Importar Alumnos</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('alumno.importar') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="form-group">
                <label for="idcurso" class="block text-sm font-medium text-gray-700">Curso:</label>
                <select name="idcurso" id="idcurso" class="form-control block w-full mt-1 p-2 border border-gray-300 rounded" required>
                    <option value="" disabled selected>Seleccione un Curso</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->idcurso }}">{{ $curso->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="file" class="block text-sm font-medium text-gray-700">Archivo Excel:</label>
                <input type="file" name="file" id="file" accept=".xlsx, .xls, .csv" class="form-control block w-full mt-1 p-2 border border-gray-300 rounded" required>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Importar</button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('alumno.index') }}" class="text-blue-600 hover:underline">Volver a la lista de alumnos</a>
        </div>
    </div>
</div>
@endsection
