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
        $userInfo = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$userInfo) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nom_usu != $username) {
            // Si no es el mismo, redirigir a la página principal del usuario logueado
            return redirect('/' . session()->get('user')->nom_usu);
        }

        $publications = DB::table('publicacion')->where('autor', $userInfo->id_usu)->orderBy('fecha_pub', 'desc')->get();
        $publicationsLength = count($publications);

        $followers = DB::table('usuario')->where('id_usu', $userInfo->id_usu)->first()->seguidores;
        $following = DB::table('usuario')->where('id_usu', $userInfo->id_usu)->first()->seguidos;

        $user = DB::table('usuario')->where('id_usu', $userInfo->id_usu)->first();

        return view(
            'user',
            [
                'user' => $user,
                'userInfo' => $userInfo,
                'publications' => $publications,
                'followers' => $followers,
                'following' => $following,
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
        $user = DB::table('info_usuario')->where('nombreUsuario', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nombreUsuario != $username) {
            // Si no es el mismo, redirigir a la página principal del usuario logueado
            return redirect('/' . session()->get('user')->username . '/profile');
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
        $user = DB::table('info_usuario')->where('nombreUsuario', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nombreUsuario != $username) {
            // Si no es el mismo, redirigir a la página principal del usuario logueado
            return redirect('/' . session()->get('user')->username . '/edit');
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
        DB::table('info_usuario')->where('nombreUsuario', $username)->update([
            'nombreUsuario' => request()->get('name'),
            'mail' => request()->get('email'),
            'constrasena' => request()->get('password')
        ]);

        // Actualizar los datos del usuario en la sesión
        session()->flush();
        session(['user', DB::table('usuario')->where('username', $username)->first()]);

        // Redirigir a la página principal del usuario {username}
        return redirect('/' . $username . '/edit');
    }

    public function publication($username, $idPublicacion)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('info_usuario')->where('nombreUsuario', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nombreUsuario != $username) {
            // Si no es el mismo, redirigir a la página principal del usuario logueado
            return redirect('/' . session()->get('user')->username);
        }

        // Comprobar que la publicación existe
        $publication = DB::table('publicacion')->where('idPublicacion', $idPublicacion)->first();
        if (!$publication) {
            // Si no existe, redirigir a la página principal del usuario {username}
            return redirect('/' . $username . '/profile');
        }

        // Obtener los comentarios de la publicación y los datos de los usuarios, junto a sus fotos de perfil
        $comments = DB::table('comentario')
            ->join('info_usuario', 'comentario.idUsuario', '=', 'info_usuario.idUsuario')
            ->join('usuario', 'info_usuario.idUsuario', '=', 'usuario.idUsuario')
            ->where('idPublicacion', $idPublicacion)
            ->get();
        $numOfComments = count($comments);

        // Si existe, redirigir a la página de la publicación
        return view(
            'userpublication',
            [
                'publication' => $publication,
                'user' => $user,
                'comments' => $comments,
                'numOfComments' => $numOfComments
            ]
        );
    }
}
