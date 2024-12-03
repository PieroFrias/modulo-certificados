@extends('layouts.app')

@section('content')
<div class="relative h-screen rounded-lg bg-gray-50">

    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Eventos - cursos</li>
        </ol>
    </nav>

    <div class="bg-white shadow-lg rounded-lg p-8 w-full mx-auto">
        <br>
        <h1 class="text-4xl font-semibold mb-8 text-center text-gray-800">Eventos / cursos</h1>

        <div class="flex justify-start gap-2 mb-6">
            <a href="{{ route('curso.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Crear Nuevo
            </a>


        </div>



        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla Responsiva -->
        <div class="overflow-x-auto w-full">
            <table class="w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="py-4 px-6 text-left">ID</th>
                        <th class="py-4 px-6 text-left">Nombre</th>
                        <th class="py-4 px-6 text-left">Certificado</th>
                        <th class="py-4 px-6 text-left">Duración</th> <!-- Nueva columna -->
                        <th class="py-4 px-6 text-left">Estado</th>
                        <th class="py-4 px-6 text-left">Total Personas</th> <!-- Nueva columna -->
                        <th class="py-4 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach($cursos as $curso)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6">{{ $curso->idcurso }}</td>
                        <td class="py-4 px-6">{{ $curso->nombre }}</td>
                        <td class="py-4 px-6">{{ $curso->certificado->nombre ?? 'No asignado' }}</td>
                        <td class="py-4 px-6">{{ $curso->hora }} : 00</td> <!-- Mostrar la hora -->
                        <td class="py-4 px-6">
                            <span class="px-4 py-1 rounded-full text-black text-sm font-semibold
                                {{ $curso->estado ? 'bg-yellow-300' : 'bg-red-500' }}">
                                {{ $curso->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">{{ $curso->alumnos_count }}</td> <!-- Mostrar total de alumnos -->
                        <td class="py-4 px-6 text-center flex justify-center items-center gap-4">

                            <a href="{{ route('curso.alumnos', $curso->idcurso) }}" class="bg-green-500  text-white py-2 px-4 rounded-md hover:bg-gray-700 active:bg-gray-500 shadow-md flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                </svg>
                                Exportar Certificados
                            </a>

                            <a   href="{{ route('curso.importaralumnos', $curso->idcurso) }}" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 active:bg-gray-500 shadow-md flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                                </svg>
                                Enviar certificados
                            </a>

                            <a href="{{ route('curso.edit', $curso->idcurso) }}" class="bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600 shadow-md" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>

                            <form action="{{ route('curso.destroy', $curso->idcurso) }}" method="POST" class="inline">
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
</div>
@endsection
