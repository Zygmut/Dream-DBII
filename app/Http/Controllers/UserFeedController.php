<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserFeedController extends Controller
{
    public function index($username)
    {
        //Comprobar si el usuario está logueado
        if (!session()->has('user')) {
            return redirect('/login');
        }

        //Comprobar si el usuario existe
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            return redirect('/login');
        }

        // Obtener las publicaciones de los usuarios que sigue el usuario logueado
        $publications = DB::table('usuario')
            ->join('info_usu', 'usuario.id_usu', '=', 'info_usu.id_usu')
            ->join('usu_usu', 'usuario.id_usu', '=', 'usu_usu.seguidor')
            ->join('publicacion', 'usu_usu.seguido', '=', 'publicacion.autor')
            ->orderBy('publicacion.fecha_pub', 'desc')
            ->where('usuario.id_usu', session()->get('user')->id_usu)
            ->get();

        return view(
            'user.userfeed',
            [
                'user' => $user,
                'publications' => $publications,
            ]
        );
    }
}
