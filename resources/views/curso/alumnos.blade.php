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
        <div class="flex justify-between items-center mb-6">
            {{-- <a href="{{ route('curso.index') }}" class="bg-blue-500 text-white p-3 rounded-full hover:bg-blue-600 shadow-md transition duration-200 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5l-6-6m0 0l6-6m-6 6h15" />
                </svg>
            </a> --}}
            <a href="{{ route('curso.generar_certificados_masivos', $curso->idcurso) }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 shadow-md transition duration-200 transform hover:scale-105 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Generar Certificados Masivos
            </a>
        </div>

        @if ($curso->alumnos->isEmpty())
            <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg mb-6 shadow-sm">
                No hay alumnos registrados en este curso.
            </div>
        @else
        <!-- Tabla Responsiva -->
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="py-4 px-6 text-left">ID</th>
                        <th class="py-4 px-6 text-left">Nombre</th>
                        <th class="py-4 px-6 text-left">Apellido</th>
                        <th class="py-4 px-6 text-left">DNI</th>
                        <th class="py-4 px-6 text-left">Correo</th>
                        <th class="py-4 px-6 text-left">Estado</th>
                        <th class="py-4 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach($curso->alumnos as $alumno)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-4 px-6">{{ $alumno->id }}</td>
                        <td class="py-4 px-6">{{ $alumno->nombre }}</td>
                        <td class="py-4 px-6">{{ $alumno->apellido }}</td>
                        <td class="py-4 px-6">{{ $alumno->dni }}</td>
                        <td class="py-4 px-6">{{ $alumno->correo }}</td>
                        <td class="py-4 px-6">{{ $alumno->estado ? 'Activo' : 'Inactivo' }}</td>
                        <td class="py-4 px-6 text-center flex justify-center items-center gap-4">
                            <!-- Generar Certificado -->
                            <a href="{{ route('curso.generar_certificado', ['idcurso' => $curso->idcurso, 'idalumno' => $alumno->id]) }}" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 shadow-md" title="Generar Certificado">
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
        @endif
    </div>
</div>
@endsection
