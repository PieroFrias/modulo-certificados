<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;

Route::get('/', [CertificadoController::class, 'index']);
Route::resource('certificados', CertificadoController::class);
//Ruta [certificados.view] para mostrar el certificado
// Route::get('certificados/{id}/view', [CertificadoController::class, 'view'])->name('certificados.view');

// ruta de create
Route::get('certificados/create', [CertificadoController::class, 'create'])->name('certificados.create');

// ruta de store
Route::post('certificados', [CertificadoController::class, 'store'])->name('certificados.store');

// ruta de show
Route::get('certificados/{id}', [CertificadoController::class, 'show'])->name('certificados.view');

// ruta de edit
Route::get('certificados/{id}/edit', [CertificadoController::class, 'edit'])->name('certificados.edit');

// Ruta [certificados.download] para descargar el certificado
Route::get('certificados/{id}/download', [CertificadoController::class, 'download'])->name('certificados.download');

// Ruta [certificados.generate] para generar el certificado
Route::get('certificados/{id}/generate', [CertificadoController::class, 'generate'])->name('certificados.generate');

// Ruta [certificados.send] para enviar el certificado por correo
Route::get('certificados/{id}/send', [CertificadoController::class, 'send'])->name('certificados.send');

// Ruta [certificados.print] para imprimir el certificado
Route::get('certificados/{id}/print', [CertificadoController::class, 'print'])->name('certificados.print');

// Ruta [certificados.delete] para eliminar el certificado
Route::delete('certificados/{id}', [CertificadoController::class, 'destroy'])->name('certificados.delete');

// Ruta [certificados.delete] para eliminar el certificado
Route::get('certificados/{id}/delete', [CertificadoController::class, 'delete'])->name('certificados.delete');








