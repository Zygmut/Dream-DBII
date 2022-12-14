<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserNotificationsController extends Controller
{
    public function index($username)
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        //Comprobar si el usuario existe
        $user = DB::table('info_usuario')->where('nombreUsuario', $username)->first();
        if (!$user) {
            return redirect('/login');
        }

        // Comprobamos que el usuario que está intentando mirar sus notificaciones es el mismo que está logueado
        if (Session::get('user')->idUsuario != $user->idUsuario) {
            return redirect('/login');
        }
        // Consultas y esas cosas
        $user = DB::table('info_usuario')->where('nombreUsuario', $username)->first();
        $

        return view(
            'user.notifications',
            [
                'user' => $user,
                'notifications' => "",
            ]
        );
    }
}
