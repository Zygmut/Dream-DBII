<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    /**
     * Redireccionamiento de la página de login
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Comprobar que el usuario está logueado
        if (Session::has('user')) {
            // Si está logueado, redirigir la página principal del usuario {username}
            return redirect('/' . Session::get('user'));
        }
        // Si no está logueado, redirigir a la página de login
        return view('login');
    }

    /**
     * Validación de los datos del formulario de login
     * 
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        // Get username and password from the form
        $data = request()->all();
        // Validate the data
        $validation = Validator::make($data, [
            'username' => 'required',
            'password' => 'required'
        ]);
        // If the validation fails, redirect to the login page
        if ($validation->fails()) {
            return redirect('/login')->withErrors($validation);
        }
        // Get the user from the database
        $user = DB::table('user')->where('username', $data['username'])->first();
        // If the user does not exist, redirect to the login page and show an error message
        if (!$user) {
            return redirect('/login')->with('error', 'El usuario no existe');
        }
        // If the user exists, check if the password is correct
        if ($user->password != $data['password']) {
            return redirect('/login')->with('error', 'La contraseña es incorrecta');
        }
        // Create a session with the user data
        session(['user' => $user]);
        // If the password is correct, redirect to {username} page
        return redirect('/' . $user->username);
    }
}
