<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Redireccionamiento de la página principal del usuario {username}
     * 
     * @return \Illuminate\Http\Response
     */
    public function index($username)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('user')->where('username', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->username != $username) {
            // Si no es el mismo, redirigir a la página principal del usuario logueado
            return redirect('/' . session()->get('user')->username);
        }

        // Si es el mismo, redirigir a la página principal del usuario {username}
        //$publications = DB::table('publication')->where('user_id', $user->id)->get();
        $publications = [1, 2, 3, 4]; // Temporal
        // Get length of the publications
        $publicationsLength = count($publications);
        // Get the user's followers and following from the database
        $followers = 700;
        $following = 888;
        return view(
            'user',
            [
                'user' => $user,
                'publications' => $publications,
                'followers' => $followers, 'following' => $following,
                'numberPublications' => $publicationsLength
            ]
        );
    }

    /**
     * Redireccionamiento de la página de edición de perfil
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('user')->where('username', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->username != $username) {
            // Si no es el mismo, redirigir a la página principal del usuario logueado
            return redirect('/' . session()->get('user')->username);
        }

        // Si es el mismo, redirigir a la página de edición de perfil del usuario {username}
        return view('edit', ['user' => $user]);
    }

    /**
     * Redireccionamiento de la página de edición de perfil
     * 
     * @return \Illuminate\Http\Response
     */
    public function update($username)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('user')->where('username', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->username != $username) {
            // Si no es el mismo, redirigir a la página principal del usuario logueado
            return redirect('/' . session()->get('user')->username);
        }

        // Comprobar que el usuario ha enviado el formulario
        if (!request()->has('name') || !request()->has('email') || !request()->has('password') || !request()->has('password_confirmation')) {
            // Si no ha enviado el formulario, redirigir a la página de edición de perfil del usuario {username}
            return redirect('/' . $username . '/edit');
        }

        // Comprobar que el usuario ha enviado el formulario correctamente
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            // Si no ha enviado el formulario correctamente, redirigir a la página de edición de perfil del usuario {username}
            return redirect('/' . $username . '/edit');
        }

        // Si ha enviado el formulario correctamente, actualizar los datos del usuario en la base de datos
        DB::table('user')->where('username', $username)->update([
            'name' => request()->get('name'),
            'email' => request()->get('email'),
            'password' => request()->get('password')
        ]);

        // Actualizar los datos del usuario en la sesión
        session()->flush();
        session(['user', DB::table('user')->where('username', $username)->first()]);

        // Redirigir a la página principal del usuario {username}
        return redirect('/' . $username);
    }
}
