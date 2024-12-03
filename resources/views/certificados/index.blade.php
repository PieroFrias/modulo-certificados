@extends('layouts.app')

@section('content')
<div class="relative h-screen rounded-lg bg-gray-50">

    <nav class="absolute top-4 left-4 px-6 text-sm text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('inicio.index') }}" class="text-blue-500 hover:underline">Inicio</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Plantillas</li>
        </ol>
    </nav>


    <div class="bg-white shadow-md rounded-lg p-6 max-w-6xl w-full mx-auto">
        <br>
        <h1 class="text-4xl font-semibold mb-6 text-center text-gray-800">Plantillas de Certificados</h1>

        <div class="flex justify-start mb-4 space-x-2"> <!-- Justify-start para alinear a la izquierda y espacio entre botones -->
            <a href="{{ route('certificados.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Subir Nuevo Certificado</a>
            <a href="{{ route('configuracion.configuracioncertificado') }}" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Personalizar Certificados</a>
        </div>


        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla Responsiva centrada -->
        <div class="flex justify-center">
            <div class="overflow-x-auto w-full ">
                <table class="min-w-full w-full bg-white border border-gray-300">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-xs sm:text-sm">
                        <tr>
                            {{-- <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Identificación</th> --}}
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Nombre</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-left">Fecha</th>
                            <th class="py-2 px-2 sm:py-3 sm:px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-xs sm:text-sm">
                        @foreach($certificados as $certificado)
                        <tr class="border-b hover:bg-gray-100">
                            {{-- <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $certificado->id }}</td> --}}
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $certificado->nombre }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6">{{ $certificado->updated_at }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-6 text-center flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <a href="{{ route('configuracion.editarconfiguracion', $certificado->id) }}" class="bg-purple-500 text-white py-1 px-2 sm:px-3 rounded hover:bg-purple-600 text-xs sm:text-sm">Personalizar</a>

                                <a href="{{ route('certificados.view', $certificado->id) }}"
                                    class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 shadow-md" title="Ver">
                                     <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                                         <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                         <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                                     </svg>
                                 </a>

                                <a href="{{ route('certificados.edit', $certificado->id) }}" class="bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600 shadow-md" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>

                                <form action="{{ route('certificados.destroy', $certificado->id) }}" method="POST" class="inline">
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
</div>
@endsection
