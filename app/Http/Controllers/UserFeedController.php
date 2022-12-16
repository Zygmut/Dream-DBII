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
        /**
         * SELECT
         *  publicacion.*,
         *  usu_autor.*,
         *  info_autor.*
         *FROM
         *  `usuario`
         *  INNER JOIN `info_usu` ON `usuario`.`id_usu` = `info_usu`.`id_usu`
         *  INNER JOIN `usu_usu` ON `usuario`.`id_usu` = `usu_usu`.`seguidor`
         *  INNER JOIN `publicacion` ON `usu_usu`.`seguido` = `publicacion`.`autor`
         *  INNER JOIN `usuario` as usu_autor ON usu_autor.id_usu = publicacion.autor
         *  INNER JOIN info_usu as info_autor ON info_autor.id_usu = usu_autor.id_usu
         *WHERE
         *  `usuario`.`id_usu` = '12345678C'
         *ORDER BY
         *  `publicacion`.`fecha_pub` DESC
         *limit
         * 5
         */

        // Obtener las publicaciones de los usuarios que sigue el usuario logueado
        $publications = DB::table('usuario')
            ->join('info_usu', 'usuario.id_usu', '=', 'info_usu.id_usu')
            ->join('usu_usu', 'usuario.id_usu', '=', 'usu_usu.seguidor')
            ->join('publicacion', 'usu_usu.seguido', '=', 'publicacion.autor')
            ->join('usuario as usu_autor', 'usu_autor.id_usu', '=', 'publicacion.autor')
            ->join('info_usu as info_autor', 'info_autor.id_usu', '=', 'usu_autor.id_usu')
            ->orderBy('publicacion.fecha_pub', 'desc')
            ->where('usuario.id_usu', session()->get('user')->id_usu)
            ->limit(5)
            ->get(['publicacion.*', 'usu_autor.*', 'info_autor.*']);

        return view(
            'user.userfeed',
            [
                'publications' => $publications,
            ]
        );
    }
}
