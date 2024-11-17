<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function index()
    {
        if(Auth::check()){
            // dd("Ya has iniciado sesión");
            return redirect()->route('inicio.index');
        }
        return view('auth.login');
    }

    // Manejar el login
    public function login(Request $request)
    {
        // Validar credenciales
        if (!Auth::validate($request->only('email','password'))) {
            return redirect()->to('login')->withErrors('Credenciales incorrectas');
        }
        // Crear una sesión
        $user = Auth::getProvider()->retrieveByCredentials($request->only('email','password'));
        Auth::login($user);
        return redirect()->route('inicio.index');

        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // if (Auth::attempt($request->only('email', 'password'))) {

        //     return redirect()->route('inicio.index');
        // }

        // return back()->withErrors(['error' => 'Credenciales incorrectas.']);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidar la sesión
        $request->session()->invalidate();

        // Regenerar el token CSRF
        $request->session()->regenerateToken();

        return redirect()->route('login'); // Redirige al formulario de login
    }

}

