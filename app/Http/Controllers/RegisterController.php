<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    /**
     * Redireccionamiento de la página de registro
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Comprobar que el usuario está logueado
        if (Session::has('user')) {
            // Si está logueado, redirigir la página principal del usuario {username}
            return redirect('/' . session()->get('user')->username);
        }
        // Si no está logueado, redirigir a la página de registro
        return view('register');
    }

    /**
     * Validación de los datos del formulario de registro
     * 
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        // Get the data from the form
        $data = request()->all();
        // Validate the data
        $validation = Validator::make($data, [
            'nombre' => 'required',
            'apellidos' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);
        // If the validation fails, redirect to the register page
        if ($validation->fails()) {
            return redirect('/register')->withErrors($validation);
        }
        // Insert the user into the database
        DB::table('user')->insert([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'username' => $data['username'],
            'password' => $data['password']
        ]);
        // If the validation succeeds, redirect to the login page and show a success message
        return redirect('/login')->with('success', 'Usuario registrado correctamente');
    }
}
