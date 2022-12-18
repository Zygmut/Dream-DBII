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
        $user = DB::table('info_usu')
            ->join('usuario', 'usuario.id_usu', 'info_usu.id_usu')
            ->where('nom_usu', $username)
            ->first();
        if (!$user) {
            return redirect('/login');
        }

        // Comprobamos que el usuario que está intentando mirar sus notificaciones es el mismo que está logueado
        if (Session::get('user')->id_usu != $user->id_usu) {
            return redirect('/login');
        }

        /**
         *SELECT
         *
         *FROM
         *    `mensaje`
         *JOIN receptor ON receptor.id_men = mensaje.id_men
         *JOIN usuario ON usuario.id_usu = receptor.id_usu
         *JOIN usuario AS autor
         *ON
         *    mensaje.id_usu = autor.id_usu
         *WHERE
         *    usuario.id_usu = '12345678C' 
         */
        $notificaciones = DB::table('mensaje')
            ->join('notificacion', 'notificacion.id_men', 'mensaje.id_men')
            ->join('usuario', 'usuario.id_usu', 'notificacion.id_usu')
            ->join('usuario as autor', 'autor.id_usu', 'mensaje.id_usu')
            ->join('info_usu as info_autor', 'info_autor.id_usu', 'autor.id_usu')
            ->where('notificacion.id_usu',  $user->id_usu)
            ->orderBy('mensaje.fecha_men', 'desc')
            ->get();

        if ($notificaciones->isEmpty()) {
            $notificaciones = [];
        }

        return view(
            'user.usernotifications',
            [
                'user' => $user,
                'notificaciones' => $notificaciones,
            ]
        );
    }

    public function delete($username, $idMensaje)
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        //Comprobar si el usuario existe
        $user = DB::table('info_usu')
            ->where('nom_usu', $username)
            ->first();

        if (!$user) {
            return redirect('/login');
        }

        $validator = Validator::make(request()->all(), [
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        DB::beginTransaction();

        DB::table('notificacion')
            ->where('id_men', '=', $idMensaje)
            ->where('id_usu', '=', $user->id_usu)
            ->delete();

        DB::commit();

        // Se recarga
        return redirect('/' . $username . '/notifications');
    }

    public function read($username, $idMensaje)
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        //Comprobar si el usuario existe
        $user = DB::table('info_usu')
            ->where('nom_usu', $username)
            ->first();

        if (!$user) {
            return redirect('/login');
        }

        $validator = Validator::make(request()->all(), [
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $notificacion = DB::table('notificacion')
            ->where('id_men', $idMensaje)
            ->where('id_usu', session()->get('user')->id_usu)
            ->first();

        if ($notificacion->estado_not == "leido") {
            return redirect('/' . request()->link);
        }

        DB::beginTransaction();
        // Actualizamos el mensaje
        DB::table('notificacion')
            ->where('id_men', '=', $idMensaje)
            ->where('id_usu', '=', session()->get('user')->id_usu)
            ->update([
                'estado_not' => "leido",
            ]);
        DB::commit();

        return redirect('/' . request()->link);
    }
}
