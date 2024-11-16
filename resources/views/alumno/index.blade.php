@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-4 sm:p-6 max-w-6xl w-full mx-auto">
        <h1 class="text-2xl sm:text-4xl font-bold mb-6 text-center text-gray-800">Lista de Alumnos</h1>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-4 sm:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 items-center">
                <a href="{{ route('alumno.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 text-center">Crear Nuevo Alumno</a>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('alumno.importar') }}" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 text-center">Importar Alumnos</a>
                    <svg class="w-6 h-6 text-gray-500 transform rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ asset('storage/plantillas/plantilla_alumnos.xlsx') }}" class="bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700 text-center">Plantilla</a>
                </div>
            </div>

            <!-- Barra de búsqueda -->
            <form action="{{ route('alumno.index') }}" method="GET" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar alumnos..."
                    class="border border-gray-300 rounded px-4 py-2 w-full sm:w-64 focus:outline-none"
                />
                <div class="flex space-x-2">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Buscar
                    </button>
                    <a
                        href="{{ route('alumno.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla Responsiva -->
        <div class="flex justify-center">
            <div class="overflow-x-auto w-full">
                <table class="min-w-full w-full bg-white border border-gray-300 text-sm">
                    <thead class="bg-gray-200 text-gray-600 uppercase">
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
                    <tbody class="text-gray-700">
                        @foreach($alumnos as $alumno)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->id }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->nombre }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->apellido }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->dni }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->curso->nombre }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->estado ? 'Activo' : 'Inactivo' }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6 text-center flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <a href="{{ route('alumno.edit', $alumno->id) }}" class="bg-yellow-500 text-white py-1 px-2 sm:px-3 rounded hover:bg-yellow-600">Editar</a>
                                <form action="{{ route('alumno.destroy', $alumno->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-1 px-2 sm:px-3 rounded hover:bg-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación personalizada -->
        <div class="flex justify-center mt-6">
            {{ $alumnos->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection
