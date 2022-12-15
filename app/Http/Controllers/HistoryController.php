<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    public function index()
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        // Obtenemos el usuario logueado
        $username = Session::get('user')->nom_usu;

        //Comprobar si el usuario existe
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            return redirect('/login');
        }

        // Obtenemos las publicaciones del usuario
        $publicaciones = DB::table('usuario')
            ->join('publicacion', 'usuario.id_usu', '=', 'publicacion.autor')
            ->leftJoin('contenido', 'publicacion.id_pub', '=', 'contenido.id_pub')
            ->where('contenido.id_pub', null)
            ->where('usuario.id_usu', $user->id_usu)
            ->orderBy('publicacion.fecha_pub', 'desc')
            ->get('publicacion.*');

        return view(
            'newhistory',
            [
                'user' => $user,
                'publicaciones' => $publicaciones,
            ]
        );
    }

    public function newHistory($idUsuario)
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        // Comprobamos que el usuario que está intentando crear una publicación es el mismo que está logueado
        if (Session::get('user')->id_usu != $idUsuario) {
            return redirect('/login');
        }

        // Validamos los datos
        $validator = Validator::make(request()->all(), [
            'descripcion' => 'required | max:255',
            'estado' => 'required',
            'publicacion' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/history/new')->withErrors($validator);
        }

        $aux = "";
        if (request()->estado == 0) {
            $aux = 'publica';
        } else {
            $aux = 'privada';
        }
        
        $idHistoria = DB::table('historia')
            ->insertGetId([
                'id_usu' => $idUsuario,
                'desc_his' => request()->descripcion,
                'estado_his' => $aux,
                'fecha_his' => date('Y-m-d H:i:s'),
            ]);


        // Insert in contenido for each publicacion selected in the form the id of the historia
        DB::table('contenido')
            ->insert([
                'id_pub' => request()->publicacion,
                'id_his' => $idHistoria,
            ]);

        return redirect('/' . Session::get('user')->nom_usu . '/profile');
    }
}
