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
            'contenido' => 'required | image | mimes:jpeg,png,jpg,gif,svg',
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
        // Save the image from the content of the request into a blob in the database in base64
        $image = request()->file('contenido');
        $image_cont = $image->openFile()->fread($image->getSize());

        DB::transaction(function () use ($idUsuario, $aux, $image_cont) {
            $idHistoria = DB::table('historia')
                ->insertGetId([
                    'id_usu' => $idUsuario,
                    'desc_his' => request()->descripcion,
                    'estado_his' => $aux,
                    'fecha_his' => date('Y-m-d H:i:s'),
                    'cont_his' => $image_cont
                ]);
            DB::table('mensaje')->insert([
                'id_usu' => $idUsuario,
                'cont_men' => "Nueva Historia!",
                'link' => Session::get('user')->nom_usu . "/story/" . $idHistoria,
                'fecha_men' => date('Y-m-d H:i:s'),
            ]);
        });
        #El insert a mensaje se hace aquí ya que no puede haber un fallo a la hora de crear la historia, a menos que 
        #desaparezca de repente el usuario, problema a nivel que se cae el servidor entero. ?? creo??


        return redirect('/' . Session::get('user')->nom_usu . '/profile');
    }

    public function viewHistory($username, $idHistoria)
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        // Comprobar que el usuario existe
        $userInfo = DB::table('info_usu')
            ->join('usuario', 'usuario.id_usu', 'info_usu.id_usu')
            ->where('nom_usu', $username)->first();
        if (!$userInfo) {
            // Si no existe, redirigir a la página de login
            return redirect('/login');
        }

        $isOwner = true;
        // Comprobar que el usuario logueado es el mismo que el que quiere acceder a su página principal
        if (session()->get('user')->nom_usu != $username) {
            $isOwner = false;
        }

        $story = DB::table('historia')
            ->where('historia.id_his', $idHistoria)
            ->first();

        // Obtenemos las publicaciones de las historias del usuario
        $publicaciones = DB::table('historia')
            ->join('contenido', 'historia.id_his', '=', 'contenido.id_his')
            ->join('publicacion', 'publicacion.id_pub', '=', 'contenido.id_pub')
            ->where('historia.id_usu', '=', $userInfo->id_usu)
            ->where('historia.id_his', '=', $idHistoria)
            ->orderByDesc('publicacion.fecha_pub')
            ->get('publicacion.*');

        return view(
            'viewhistory',
            [
                'publicaciones' => $publicaciones,
                'userInfo' => $userInfo,
                'story' => $story,
                'isOwner' => $isOwner,
            ]
        );
    }

    public function editHistory($username, $idHistoria)
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

        // Comprobar que la historia existe
        $historia = DB::table('historia')->where('id_his', $idHistoria)->first();
        if (!$historia) {
            // Si no existe, redirigir a la página de login
            return back();
        }

        // Comprobar que el usuario que está intentando editar la historia es el mismo que está logueado
        if (Session::get('user')->id_usu != $userInfo->id_usu) {
            return back();
        }

        // Obtener todas las publicaciones del usuario
        $publications = DB::table('publicacion')
            ->join('usuario', 'usuario.id_usu', '=', 'publicacion.autor')
            ->where('usuario.id_usu', $userInfo->id_usu)
            ->orderByDesc('publicacion.fecha_pub')
            ->get('publicacion.*');

        $publicacionesDeLaHistoria = DB::table('publicacion')
            ->join('contenido', 'publicacion.id_pub', '=', 'contenido.id_pub')
            ->join('historia', 'historia.id_his', '=', 'contenido.id_his')
            ->where('historia.id_his', '=', $idHistoria)
            ->orderByDesc('publicacion.fecha_pub')
            ->get('publicacion.id_pub');

        $aux = [];
        foreach ($publicacionesDeLaHistoria as $publicacion) {
            $aux[] = $publicacion->id_pub;
        }

        return view(
            'user.useredithistory',
            [
                'history' => $historia,
                'userInfo' => $userInfo,
                'idHistoria' => $idHistoria,
                'publicaciones' => $publications,
                'publicacionesDeLaHistoria' => $aux,
            ]
        );
    }

    public function updateHistory($username, $idHistoria)
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

        // Comprobar que la historia existe
        $historia = DB::table('historia')->where('id_his', $idHistoria)->first();
        if (!$historia) {
            // Si no existe, redirigir a la página de login
            return back();
        }

        // Comprobar que el usuario que está intentando editar la historia es el mismo que está logueado
        if (Session::get('user')->id_usu != $userInfo->id_usu) {
            return back();
        }

        // Validamos los datos
        $validator = Validator::make(request()->all(), [
            'descripcion' => 'required | max:255',
            'estado' => 'required',
            'publicaciones' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/' . $username . '/history/' . $idHistoria . '/edit')->withErrors($validator);
        }

        // Actualizamos la historia
        $data = [];
        foreach (request()->publicaciones as $publicacion) {
            $data[] = [
                'id_his' => $idHistoria,
                'id_pub' => $publicacion,
            ];
        }

        DB::transaction(
            function () use ($data, $idHistoria) {
                if (request()->contenido != null) {
                    // Save the image from the content of the request into a blob in the database in base64
                    $image = request()->file('contenido');
                    $image_cont = $image->openFile()->fread($image->getSize());
                    DB::table('historia')->where('id_his', $idHistoria)
                        ->update([
                            'desc_his' => request()->descripcion,
                            'estado_his' => request()->estado,
                            'cont_his' => $image_cont,
                            'fecha_his' => date('Y-m-d H:i:s'),
                        ]);
                } else {
                    DB::table('historia')->where('id_his', $idHistoria)
                        ->update([
                            'desc_his' => request()->descripcion,
                            'estado_his' => request()->estado,
                            'fecha_his' => date('Y-m-d H:i:s'),
                        ]);
                }
                DB::table('contenido')
                    ->insert($data);
            }
        );

        return redirect('/' . $username . '/story/' . $idHistoria);
    }

    public function deleteHistory($username, $idHistoria)
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

        // Comprobar que la historia existe
        $historia = DB::table('historia')->where('id_his', $idHistoria)->first();
        if (!$historia) {
            // Si no existe, redirigir a la página de login
            return redirect('/' . $username . '/profile');
        }

        // Comprobar que el usuario que está intentando editar la historia es el mismo que está logueado
        if (Session::get('user')->id_usu != $userInfo->id_usu) {
            return redirect('/' . $username . '/profile');
        }

        DB::transaction(function () use ($idHistoria) {
            // Eliminamos el contenido de la historia
            DB::table('contenido')
                ->where('id_his', '=', $idHistoria)
                ->delete();

            // Eliminamos la historia
            DB::table('historia')
                ->where('id_his', '=', $idHistoria)
                ->delete();
        });

        return redirect('/' . $username . '/profile');
    }
}
