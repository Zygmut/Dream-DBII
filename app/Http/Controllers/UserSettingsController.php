<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserSettingsController extends Controller
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

        // Comprobamos que el usuario que está intentando modificar sus datos es el mismo que está logueado
        if (Session::get('user')->idUsuario != $user->idUsuario) {
            return redirect('/login');
        }

        // Obtenemos los datos del usuario
        /**
         * SELECT
         *  *
         *FROM
         *    persona
         *JOIN usuario ON usuario.idPersona = persona.idPersona
         *JOIN info_usuario ON info_usuario.idUsuario = usuario.idUsuario
         */
        $userInfo = DB::table('persona')
            ->join('usuario', 'usuario.idPersona', '=', 'persona.idPersona')
            ->join('info_usuario', 'info_usuario.idUsuario', '=', 'usuario.idUsuario')
            ->where('info_usuario.nombreUsuario', $username)
            ->first();

        return view(
            'usersettings',
            [
                'userInfo' => $userInfo
            ]
        );
    }

    public function update($username)
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

        // Comprobamos que el usuario que está intentando modificar sus datos es el mismo que está logueado
        if (Session::get('user')->idUsuario != $user->idUsuario) {
            return redirect('/user/' . Session::get('user')->nombreUsuario . '/settings');
        }

        // Validamos los datos
        $validator = Validator::make(request()->all(), [
            'nombre' => 'required | max:255',
            'apellidos' => 'required | max:255',
            'nombreUsuario' => 'required | max:255',
            'mail' => 'required | email | max:255',
            'telefono' => 'required | max:255',
            'fechaNacimiento' => 'required | date',
            'descripcion' => 'required | max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/user/' . $username . '/settings')->withErrors($validator);
        }

        $idPersona = DB::table('usuario')
            ->where('idUsuario', $user->idUsuario)
            ->first()
            ->idPersona;

        // Actualizamos los datos del usuario (persona, usuario, info_usuario)        
        DB::table('persona')
            ->where('idPersona', $idPersona)
            ->update([
                'nombre' => request()->nombre,
                'apellidos' => request()->apellidos,
                'telef' => request()->telefono,
            ]);

        DB::table('usuario')
            ->where('idUsuario', $user->idUsuario)
            ->update([
                'descripcion' => request()->descripcion
                //'fotoPerfil' => request()->fotoPerfil
            ]);

        DB::table('info_usuario')
            ->where('idUsuario', $user->idUsuario)
            ->update([
                'mail' => request()->mail,
                'nombreUsuario' => request()->nombreUsuario
            ]);

        return redirect('/user/' . $username . '/settings');
    }
}
