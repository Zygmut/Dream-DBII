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
        $user = DB::table('info_usuario')->where('nombreUsuario', $username)->first();
        if (!$user) {
            return redirect('/login');
        }

        // Obtener las publicaciones de los usuarios que sigue el usuario logueado
        $publications = DB::table('usuario')
            ->join('info_usuario', 'usuario.idUsuario', '=', 'info_usuario.idUsuario')
            ->join('usuario_usario', 'usuario.idUsuario', '=', 'usuario_usario.idUsuarioSeguidor')
            ->join('publicacion', 'usuario_usario.idUsuarioSeguido', '=', 'publicacion.idUsuarioAutor')
            ->orderBy('publicacion.fecha', 'desc')
            ->where('usuario.idUsuario', session()->get('user')->idUsuario)
            ->get();

        $comments = [];

        $numComments = 0;

        return view(
            'userfeed',
            [
                'user' => $user,
                'publications' => $publications,
            ]
        );
    }
}
