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
        $isOwner = true;
        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nom_usu != $username) {
            $isOwner = false;
        }

        $publications = DB::table('publicacion')
            ->leftJoin('contenido', 'publicacion.id_pub', 'contenido.id_pub')
            ->where('contenido.id_pub', null)
            ->where('publicacion.autor', $userInfo->id_usu)
            ->orderBy('fecha_pub', 'desc')
            ->get('publicacion.*');

        $publicationsLength = count($publications);

        $rts = DB::table('publicacion')
            ->join('rt', 'rt.id_pub', 'publicacion.id_pub')
            ->join('info_usu', 'info_usu.id_usu', 'publicacion.autor')
            ->where('rt.id_usu', $userInfo->id_usu)
            ->get();

        $notifications = DB::table('notificacion')
            ->where('notificacion.id_usu', $userInfo->id_usu)
            ->where('notificacion.estado_not', 'no leido')
            ->get();

        $notificationsLength = count($notifications);

        $followers = DB::table('usuario')->where('id_usu', $userInfo->id_usu)->first()->seguidores;
        $following = DB::table('usuario')->where('id_usu', $userInfo->id_usu)->first()->seguidos;

        $user = DB::table('usuario')->where('id_usu', $userInfo->id_usu)->first();
        $per = DB::table('persona')->where('dni', $user->id_usu)->first();

        $isFollowing = false;
        if (!$isOwner) {
            // Comprobar si el usuario sigue a la persona que está viendo
            $aux = DB::table('usu_usu')
                // WHERE seguido=userInfo AND seguidor = session User
                ->where('seguido', $userInfo->id_usu)
                ->where('seguidor', session()->get('user')->id_usu)
                ->first();
            if ($aux != null) {
                $isFollowing = true;
            }
        }

        $stories = DB::table('historia')
            ->join('usuario', 'historia.id_usu', '=', 'usuario.id_usu')
            ->where('usuario.id_usu', $userInfo->id_usu)
            ->orderBy('fecha_his', 'desc')
            ->get('historia.*');

        return view(
            'user.user',
            [
                'user' => $user,
                'per' => $per,
                'userInfo' => $userInfo,
                'publications' => $publications,
                'rts' => $rts,
                'followers' => $followers,
                'following' => $following,
                'numberPublications' => $publicationsLength,
                'numberNotificactions' => $notificationsLength,
                'isOwner' => $isOwner,
                'isFollowing' => $isFollowing,
                'stories' => $stories,
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
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }
        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nom_usu != $username) {
            // Si no es el mismo, redirigir a la página principal del usuario logueado
            return redirect('/' . session()->get('user')->nom_usu);
        }

        return view(
            'user.edit',
            [
                'user' => $user,
            ]
        );
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
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nom_usu != $username) {
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
        return redirect('/' . $username . '/settings');
    }

    public function publication($username, $idPublicacion)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('info_usu')
            ->join('usuario', 'usuario.id_usu', 'info_usu.id_usu')
            ->where('nom_usu', $username)
            ->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que la publicación existe
        $publication = DB::table('publicacion')->where('id_pub', $idPublicacion)->first();
        if (!$publication) {
            // Si no existe, redirigir a la página principal del usuario {username}
            return redirect('/' . $username . '/profile');
        }

        $isOwner = true;
        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nom_usu != $username) {
            $isOwner = false;
        }

        // Obtener los comentarios de la publicación y los datos de los usuarios, junto a sus fotos de perfil
        $comments = DB::table('comentario')
            ->join('info_usu', 'comentario.id_usu', '=', 'info_usu.id_usu')
            ->join('usuario', 'info_usu.id_usu', '=', 'usuario.id_usu')
            ->where('id_pub', $idPublicacion)
            ->orderBy('comentario.fecha_com', 'ASC')
            ->get();
        $numOfComments = count($comments);

        // Si existe, redirigir a la página de la publicación
        return view(
            'user.userpublication',
            [
                'publication' => $publication,
                'user' => $user,
                'isOwner' => $isOwner,
                'comments' => $comments,
                'numOfComments' => $numOfComments,
            ]
        );
    }

    public function follow($username, $usernamefollow)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuarioFollow existe
        $userfollow = DB::table('info_usu')->where('nom_usu', $usernamefollow)->first();
        if (!$userfollow) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        $followedUser = DB::table('info_usu')
            ->where('nom_usu', '=', $usernamefollow)
            ->get('id_usu')
            ->first();

        $userFollowing = DB::table('info_usu')
            ->where('nom_usu', '=', $username)
            ->get('id_usu')
            ->first();

        DB::transaction(function () use ($followedUser, $userFollowing) {
            // Hacer que el usuario {username} siga al usuario {usernamefollow}
            DB::table('usu_usu')->insert([
                'seguido' => $followedUser->id_usu,
                'seguidor' => $userFollowing->id_usu
            ]);

            //Incrementar el número de usuarios seguidos en el usuario que ha seguido
            DB::table('usuario')
                ->where('id_usu', '=', $userFollowing->id_usu)
                ->increment('seguidos'); // = seguidos + 1
            //Incrementar número de seguidores en el usuario que ha sido seguido
            DB::table('usuario')
                ->where('id_usu', '=', $followedUser->id_usu)
                ->increment('seguidores');
            // https://es.stackoverflow.com/questions/111887/incrementar-el-valor-de-un-campo
        });

        // Redirigir a la página principal del usuario {usernamefollow}
        return redirect('/' . $usernamefollow . '/profile');
    }

    public function unfollow($username, $usernamefollow)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $userfollow = DB::table('info_usu')->where('nom_usu', $usernamefollow)->first();
        if (!$userfollow) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        $followedUser = DB::table('info_usu')
            ->where('nom_usu', '=', $usernamefollow)
            ->get('id_usu')
            ->first();

        $userFollowing = DB::table('info_usu')
            ->where('nom_usu', '=', $username)
            ->get('id_usu')
            ->first();

        DB::transaction(function () use ($followedUser, $userFollowing) {
            // Hacer que el usuario {username} deje de seguir al usuario {usernamefollow}
            DB::table('usu_usu')
                ->where('seguido', '=', $followedUser->id_usu)
                ->where('seguidor', '=', $userFollowing->id_usu)
                ->delete();

            //Decrementar el número de usuarios seguidos en el usuario que ha dejado de seguir
            DB::table('usuario')
                ->where('id_usu', '=', $userFollowing->id_usu)
                ->decrement('seguidos'); // = seguidos - 1

            //Decrementar número de seguidores en el usuario que ha dejado de ser seguido
            DB::table('usuario')
                ->where('id_usu', '=', $followedUser->id_usu)
                ->decrement('seguidores'); // = seguidos - 1
        });

        // Redirigir a la página principal del usuario {usernamefollow}
        return redirect('/' . $usernamefollow . '/profile');
    }

    public function followers($username)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // De cada follower necesitamos:
        // - Foto de perfil
        // - Nombre de usuario
        // - Nombre 
        // - Apellidos
        // - Número de seguidores
        // - Número de seguidos

        // Obtener los seguidores del usuario {username}
        $followers =  DB::select(DB::raw(
            '
            SELECT
                p.foto_perfil,
                p.seguidores,
                p.seguidos,
                info_usu.nom_usu,
                p.nom_per,
                p.apellidos
            FROM
                INFO_USU
            JOIN(
                    (
                    SELECT usuario.id_usu,
                        usuario.foto_perfil,
                        usuario.seguidores,
                        usuario.seguidos,
                        persona.nom_per,
                        persona.apellidos
                    FROM
                        persona
                    JOIN(
                            USUARIO
                        JOIN usu_usu ON usu_usu.seguido = \'' . $user->id_usu . '\' AND usu_usu.seguidor = usuario.id_usu
                        )
                    ON
                        persona.DNI = usuario.id_usu
                ) AS p
                )
            ON
                info_usu.id_usu = p.id_usu
            '
        ));

        return view(
            'user.userfollowers',
            [
                'followers' => $followers
            ]
        );
    }

    public function following($username)
    {
        // Comprobar que el usuario está logueado
        if (!session()->has('user')) {
            // Si no está logueado, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $user = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$user) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }
        // De cada follower necesitamos:
        // - Foto de perfil
        // - Nombre de usuario
        // - Nombre
        // - Nombre apellidos
        // - Número de seguidores
        // - Número de seguidos

        // Obtener los usuarios que sigue el usuario {username}
        $following = DB::select(DB::raw(
            '
            SELECT
                p.foto_perfil,
                p.seguidores,
                p.seguidos,
                info_usu.nom_usu,
                p.nom_per,
                p.apellidos
            FROM
                INFO_USU
            JOIN(
                (
                SELECT
                    usuario.id_usu,
                    usuario.foto_perfil,
                    usuario.seguidores,
                    usuario.seguidos,
                    persona.nom_per,
                    persona.apellidos
                FROM
                    persona
                    JOIN(
                    USUARIO
                    JOIN usu_usu ON usu_usu.seguidor = \'' . $user->id_usu . '\'
                    AND usu_usu.seguido = usuario.id_usu
                    ) ON persona.DNI = usuario.id_usu
                ) AS p
            ) ON info_usu.id_usu = p.id_usu
            '
        ));

        return view(
            'user.userfollowing',
            [
                'following' => $following
            ]
        );
    }

    public function deleteAccount($username)
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $userInfo = DB::table('info_usu')->where('nom_usu', $username)->first();
        if (!$userInfo) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        // Comprobar que el usuario que está intentando editar la historia es el mismo que está logueado
        if (Session::get('user')->id_usu != $userInfo->id_usu) {
            return redirect('/' . $username . '/profile');
        }

        // de final a principio
        // persona
        // usuario
        // info_usu
        // usu_usu
        // mensaje
        // notificaciones
        // publicacion
        // comentario
        // RT
        // historia
        // contenido

        // Eliminar el usuario de la base de datos
        DB::transaction(function () use ($userInfo) {
            // Eliminar contenido de todas las historias
            DB::table('contenido')
                ->join('historia', 'historia.id_his', '=', 'contenido.id_his')
                ->where('historia.id_usu', $userInfo->id_usu)
                ->delete();

            // Eliminar historias
            DB::table('historia')->where('id_usu', $userInfo->id_usu)->delete();

            // Eliminar rt
            DB::table('rt')->where('id_usu', $userInfo->id_usu)->delete();

            // Eliminar los comentarios
            DB::table('comentario')->where('id_usu', $userInfo->id_usu)->delete();

            // Eliminar publicaciones
            DB::table('publicacion')->where('autor', $userInfo->id_usu)->delete();

            // Eliminar mensajes
            DB::table('mensaje')->where('id_usu', $userInfo->id_usu)->delete();

            // Decrementar el número de seguidores de los usuarios que seguía y de los que lo seguían
            DB::table('usuario')
                ->join('usu_usu', 'usu_usu.seguido', '=', 'usuario.id_usu')
                ->where('usu_usu.seguidor', $userInfo->id_usu)
                ->decrement('seguidores');

            DB::table('usuario')
                ->join('usu_usu', 'usu_usu.seguidor', '=', 'usuario.id_usu')
                ->where('usu_usu.seguido', $userInfo->id_usu)
                ->decrement('seguidos');

            // Eliminar usu_usu
            DB::table('usu_usu')
                ->where('seguidor', $userInfo->id_usu)
                ->delete();

            DB::table('usu_usu')
                ->where('seguido', $userInfo->id_usu)
                ->delete();

            // Eliminar el usuario de la tabla info_usu
            DB::table('info_usu')->where('id_usu', $userInfo->id_usu)->delete();

            // Eliminar el usuario de la tabla usuario
            DB::table('usuario')->where('id_usu', $userInfo->id_usu)->delete();

            // Eliminar el usuario de la tabla persona
            DB::table('persona')->where('DNI', $userInfo->id_usu)->delete();
        });

        return redirect(session('user')->nom_usu . '/logout');
    }
}
