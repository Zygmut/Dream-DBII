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
            'nombre' => 'required | max:50 | min:3 | regex:/^[a-zA-Z]+$/',
            'apellidos' => 'required | max:255 | regex:/^[a-zA-Z ]+$/',
            'telefono' => 'required | max:9 | min:9 | regex:/^[0-9]+$/',
            'fechaNacimiento' => 'required | date',
            'mail' => 'required | email | max:255',
            'nombreUsuario' => 'required | max:255 | min:3 | regex:/^[a-zA-Z0-9]+$/',
            'contrasena' => 'required | max:255 | min:3 | regex:/^[a-zA-Z0-9]+$/',
        ]);
        // If the validation fails, redirect to the register page
        if ($validation->fails()) {
            return redirect('/register')->withErrors($validation);
        }

        // Comprobar que el nombre de usuario o el mail no está en uso
        $user = DB::table('usuarios')->where('nombreUsuario', $data['nombreUsuario'])->orWhere('mail', $data['mail'])->first();
        if ($user) {
            return redirect('/register')->withErrors([
                'nombreUsuario' => 'El nombre de usuario o email ya está en uso',
                'email' => 'El nombre de usuario o email ya está en uso'
            ]);
        }

        // Insertar datos en tabla persona
        $idPersona = DB::table('persona')->insertGetId([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'telefono' => $data['telefono'],
            'fechaNacimiento' => $data['fechaNacimiento'],
        ]);
        // Insertar datos en tabla usuario
        $idUser = DB::table('usuario')->insertGetId([
            'contrasena' => $data['contrasena'],
            'descripcion' => 'Hola, soy ' . $data['nombreUsuario'],
            'numSeguidores' => 0,
            'numSeguidos' => 0,
            'fotoPerfil' => 'default.jpg', // Mirar como subir una imagen por defecto a la base de datos
            'idPersona' => $idPersona
        ]);
        // Insertar datos en tabla info_usuario
        DB::table('info_usuario')->insert([
            'nombreUsuario' => $data['nombreUsuario'],
            'mail' => $data['mail'],
            'idUsuario' => $idUser
        ]);

        // Redirigir a la página de login
        return redirect('/login');
    }
}
