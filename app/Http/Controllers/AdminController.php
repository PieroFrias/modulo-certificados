<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Muestra la vista de inicio del administrador.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retorna la vista 'VistaInicio'
        return view('inicio.index');
    }
}

