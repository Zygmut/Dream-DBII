<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;


class IndexController extends Controller
{
    /**
     * Redireccionamiento de la página principal
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Comprobar que el usuario está logueado
        if (Session::has('user')) {
            // Si está logueado, redirigir la página principal del usuario {username}
            return redirect('/' . session()->get('user')->nom_usu. '/profile');
        }
        // Si no está logueado, redirigir a la página de login
        return redirect('/login');
    }
}
