<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


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
            return redirect('/' . session()->get('user')->nombreUsuario . '/profile');
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
        /**
         * Obtener usuario de la siguiente consulta
         *
         * SELECT
         *     *
         *FROM
         *    usuario,
         *    info_usuario
         *WHERE
         *    usuario.idUsuario = info_usuario.idUsuario AND usuario.contrasena = '{password}' AND info_usuario.nombreUsuario = '{username}';
         */
        $user = DB::table('usuario')
            ->join('info_usu', 'usuario.id_usu', '=', 'info_usu.id_usu')
            ->where('nom_usu', $data['username'])
            ->where('pass', $data['password'])
            ->first();

        // If the user does not exist, redirect to the login page and show an error message
        if (!$user) {
            return redirect('/login')->with('error', 'El usuario no existe');
        }
        // If the user exists, check if the password is correct
        if ($user->pass != $data['password']) {
            return redirect('/login')->with('error', 'La contraseña es incorrecta');
        }
        // Create a session with the user data
        session(['user' => $user]);
        // If the password is correct, redirect to {username} page
        return redirect('/' . $user->nom_usu. '/profile');
    }

    public function logout()
    {
        // Delete the session
        session()->forget(['user']);
        // Redirect to the login page
        return redirect('/hello');
    }
}
