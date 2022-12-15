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
        if (Session::get('user')->id_usu != $user->id_usu) {
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
            'user.usersettings',
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
        if (Session::get('user')->id_usu != $user->id_usu) {
            return redirect('/' . Session::get('user')->nom_usu . '/settings');
        }

        $validator = null;
        // Ver porque algunas imagenes, aunque cumplan los requisitos
        // son rechazadas por el validartor
        // Validamos los datos
        $validator = Validator::make(request()->all(), [
            'nom_per' => 'required | max:255',
            'apellidos' => 'required | max:255',
            'nom_usu' => 'required | max:255',
            'pass' => 'required | max:255',
            'mail' => 'required | email | max:255',
            'telf' => 'required | max:255',
            'nacimiento' => 'required | date',
            'description' => 'required | max:256',
            'perfil' => 'nullable | image | mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return redirect('/' . $username . '/settings')->withErrors($validator);
        }

        if (request()->nom_usu != $username) {
            // Comprobamos que el nombre de usuario no esté en uso
            $userExists = DB::table('info_usu')
                ->where('nom_usu', '=', request()->nom_usu)
                ->first();
            if ($userExists) {
                return redirect('/' . $username . '/settings')->withErrors(['nom_usu' => 'El nombre de usuario ya está en uso']);
            }
        }

        $idPersona = DB::table('usuario')
            ->where('id_usu', $user->id_usu)
            ->first()
            ->id_usu;

        // Actualizamos los datos del usuario (persona, usuario, info_usuario)        
        DB::table('persona')
            ->where('dni', $idPersona)
            ->update([
                'nom_per' => request()->nom_per,
                'apellidos' => request()->apellidos,
                'telf' => request()->telf,
            ]);

        DB::table('usuario')
            ->where('id_usu', $user->id_usu)
            ->update([
                'description' => request()->description,
            ]);

        if (request()->perfil != null) {
            $image = request()->file('perfil');
            $image_cont = $image->openFile()->fread($image->getSize());
            DB::table('usuario')
                ->where('id_usu', $user->id_usu)
                ->update([
                    'foto_perfil' => $image_cont
                ]);
        }

        DB::table('info_usu')
            ->where('id_usu', $user->id_usu)
            ->update([
                'mail' => request()->mail,
                'nom_usu' => request()->nom_usu
            ]);

        return redirect('/' . request()->nom_usu . '/profile');
    }
}
