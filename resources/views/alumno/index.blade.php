@extends('layouts.app')

@section('content')



<div class="relative h-screen rounded-lg bg-gray-50">

    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Personas</li>
        </ol>
    </nav>

    <div class="bg-white shadow-lg rounded-lg p-8 w-full mx-auto">
        <br>



        <h1 class="text-4xl font-semibold mb-8 text-center text-gray-800">Lista de Personas</h1>



        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-4 sm:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 items-center">
                <a href="{{ route('alumno.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 text-center">Agregar Nueva Persona</a>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('alumno.importar') }}" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 text-center">Importar Personas</a>
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
                    class="border border-gray-300 rounded px-4 py-2 w-full sm:w-64 focus:outline-none"/>

                    <div class="flex space-x-2 pl-2">
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
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Correo</th> <!-- Nueva columna -->
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
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->correo  ?? 'No asignado' }}</td> <!-- Mostrar correo -->
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->curso ? $alumno->curso->nombre : 'Sin Curso' }}</td>

                            <td class="py-4 px-6">
                                <span class="px-4 py-1 rounded-full text-white text-sm font-semibold
                                    {{ $alumno->estado ? 'bg-yellow-300' : 'bg-red-500' }}">
                                    {{ $alumno->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>

                            <td class="py-2 px-2 sm:py-3 sm:px-6 text-center flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">

                                <a href="{{ route('alumno.edit', $alumno->id) }}" class="bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600 shadow-md" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>

                                <form action="{{ route('alumno.destroy', $alumno->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded-md hover:bg-red-600 shadow-md" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
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
