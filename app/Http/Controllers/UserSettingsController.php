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
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            return redirect('/login');
        }

        // Comprobamos que el usuario que está intentando modificar sus datos es el mismo que está logueado
        if (Session::get('user')-> id_usu != $user->id_usu) {
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
            ->join('usuario', 'usuario.id_usu', '=', 'persona.dni')
            ->join('info_usu', 'info_usu.id_usu', '=', 'usuario.id_usu')
            ->where('info_usu.nom_usu', $username)
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
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            return redirect('/login');
        }

        // Comprobamos que el usuario que está intentando modificar sus datos es el mismo que está logueado
        if (Session::get('user')->id_usu != $user->idUsuario) {
            return redirect('/user/' . Session::get('user')->nom_usu. '/settings');
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
            ->where('id_usu', $user->id_usu)
            ->first()
            ->dni;

        // Actualizamos los datos del usuario (persona, usuario, info_usuario)        
        DB::table('persona')
            ->where('id_per', $idPersona)
            ->update([
                'nom_per' => request()->nombre,
                'apellidos' => request()->apellidos,
                'telf' => request()->telefono,
            ]);

        DB::table('usuario')
            ->where('id_usu', $user->id_usu)
            ->update([
                'description' => request()->descripcion
                //'fotoPerfil' => request()->fotoPerfil
            ]);

        DB::table('info_usu')
            ->where('id_usu', $user->id_usu)
            ->update([
                'mail' => request()->mail,
                'nom_usu' => request()->nombreUsuario
            ]);

        return redirect('/user/' . $username . '/settings');
    }
}
