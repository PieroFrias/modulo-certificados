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
            <li class="text-gray-700">Lista de Personas</li>
        </ol>
    </nav>

    <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-6xl mx-auto">
        <br>
        <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">Lista Personas Evento/Curso: {{ strtoupper($curso->nombre) }}</h1>



        <!-- Botones superiores -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-4 sm:space-y-0">
            <a href="{{ route('curso.generar_certificados_masivos', $curso->idcurso) }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700 shadow-md transition duration-200 transform hover:scale-105 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Generar Certificados Masivos
            </a>

            <!-- Mostrar conteo de alumnos activos e inactivos -->
            <div class="text-left">
                <p class="text-gray-700">
                    <span class="font-bold">Activos:</span> {{ $activos }}
                </p>
                <p class="text-gray-700">
                    <span class="font-bold">Inactivos:</span> {{ $inactivos }}
                </p>
            </div>

            <!-- Barra de búsqueda -->
        <form action="{{ route('curso.alumnos', $curso->idcurso) }}" method="GET" class="mb-6 flex flex-col sm:flex-row items-center gap-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nombre, apellido, correo o DNI"
                class="border border-gray-300 rounded px-4 py-2 w-full sm:w-1/3 focus:outline-none focus:ring focus:ring-blue-300">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Buscar
            </button>
            <a href="{{ route('curso.alumnos', $curso->idcurso) }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
                Limpiar
            </a>
        </form>
        </div>

        @if ($alumnos->isEmpty())
            <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg mb-6 shadow-sm">
                No hay alumnos registrados en este curso.
            </div>
        @else
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
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Correo</th>
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
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $alumno->correo }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">
                                <span class="px-4 py-1 rounded-full text-black text-sm font-semibold
                                    {{ $alumno->estado ? 'bg-yellow-300' : 'bg-red-500' }}">
                                    {{ $alumno->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center flex justify-center items-center gap-4">
                                <!-- Generar Certificado -->
                                <a href="{{ route('curso.generar_certificado', ['idcurso' => $curso->idcurso, 'idalumno' => $alumno->id]) }}"
                                    class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 shadow-md"
                                    title="Generar Certificado">
                                     Generar Certificado
                                 </a>

                                <!-- Editar Alumno -->
                                <a href="{{ route('alumno.edit', $alumno->id) }}" class="bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600 shadow-md" title="Editar Persona">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <!-- Eliminar Alumno -->
                                <form action="{{ route('alumno.destroy', $alumno->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded-md hover:bg-red-600 shadow-md" title="Eliminar Alumno">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
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
            {{ $alumnos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
