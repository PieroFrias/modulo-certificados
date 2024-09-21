@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Certificado</h1>

    <!-- Mostrar el archivo PDF actual -->
    @if($certificado->template)
        <div class="mb-4">
            <h3>Vista previa del PDF actual:</h3>
            <embed src="{{ asset('storage/certificados/' . $certificado->template) }}" type="application/pdf" width="100%" height="500px" />
            <!-- O usar iframe -->
            <!-- <iframe src="{{ asset('storage/certificados/' . $certificado->template) }}" width="100%" height="500px"></iframe> -->
        </div>
    @endif

    <form action="{{ route('certificados.update', $certificado->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $certificado->nombre }}" required>
        </div>

        <div class="form-group">
            <label for="template">Cambiar Plantilla PDF</label>
            <input type="file" name="template" id="template" class="form-control" accept="application/pdf">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Certificado</button>
    </form>
</div>
@endsection
