@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-6xl w-full mx-auto">
        <h1 class="text-4xl font-bold mb-6 text-center text-gray-800">Lista de Alumnos</h1>

        <div class="flex justify-center mb-4">
            <a href="{{ route('alumno.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Crear Nuevo Alumno</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla Responsiva -->
        <div class="flex justify-center">
            <div class="overflow-x-auto w-full">
                <table class="min-w-full w-full bg-white border border-gray-300">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-xs sm:text-sm">
                        <tr>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">ID</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Nombre</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Apellido</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">DNI</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Curso</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Estado</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-xs sm:text-sm">
                        @foreach($alumnos as $alumno)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->id }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->nombre }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->apellido }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->dni }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->curso->nombre }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->estado ? 'Activo' : 'Inactivo' }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6 text-center flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <a href="{{ route('alumno.edit', $alumno->id) }}" class="bg-yellow-500 text-white py-1 px-2 sm:px-3 rounded hover:bg-yellow-600 text-xs sm:text-sm">Editar</a>
                                <form action="{{ route('alumno.destroy', $alumno->id) }}" method="POST" class="inline">
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
