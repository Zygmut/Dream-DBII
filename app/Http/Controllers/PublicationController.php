<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PublicationController extends Controller
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

        return view('newpublication');
    }

    public function newcomment($idUsuario, $idPublicacion)
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        // Validamos los datos
        $validator = Validator::make(request()->all(), [
            'comentario' => 'required | max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        DB::transaction(function () use ($idPublicacion) {
            DB::table('comentario')->insert([
                'id_pub' => $idPublicacion,
                'id_usu' => session()->get('user')->id_usu,
                'cont_com' => request()->comentario,
                'fecha_com' => date('Y-m-d H:i:s'),
            ]);
        });

        return back();
    }

    public function newPublication($idUsuario)
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
            'contenido' => 'required | image | mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return redirect('/publication/new')->withErrors($validator);
        }

        // Save the image from the content of the request into a blob in the database in base64
        $image = request()->file('contenido');
        $image_cont = $image->openFile()->fread($image->getSize());

        DB::transaction(
            function () use ($idUsuario, $image_cont) {
                // Insert into 'publicacion' (idUsuarioAutor, descripcion, contenido, fecha)
                // values (idUsuario, descripcion, contenido, fecha)
                $idPublicacion = DB::table('publicacion')
                    ->insertGetId([
                        'autor' => $idUsuario,
                        'desc_pub' => request()->descripcion,
                        'cont_pub' => $image_cont,
                        'fecha_pub' => date('Y-m-d H:i:s'),
                    ]);

                //Insert into 'mensaje' y 'receptor' (idUsuarioEmisor, idMensaje, contMensaje, fecha_men == fecha_creacion) (idUsuarioReceptor, idMensaje)
                DB::table('mensaje')->insert([
                    'id_usu' => $idUsuario,
                    'cont_men' => "Nueva Publicación!",
                    'link' => Session::get('user')->nom_usu . "/publication/" . $idPublicacion,
                    'fecha_men' => date('Y-m-d H:i:s'),
                ]);
            }
        );

        return redirect('/' . Session::get('user')->nom_usu . '/profile');
    }

    public function rt($username, $idPublicacion)
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

        //Comprobar si el usuario ya ha retuiteado la publicación
        $rt = DB::table('rt')
            ->where('id_usu', $user->id_usu)
            ->where('id_pub', $idPublicacion)
            ->first();

        if ($rt) {
            DB::table('rt')
                ->where('id_usu', $user->id_usu)
                ->where('id_pub', $idPublicacion)
                ->delete();
            return back();
        }

        DB::transaction(function () use ($idPublicacion, $user) {
            //Insert into 'rt' (idUsuario, idPublicacion, fecha)
            //values (idUsuario, idPublicacion, fecha)
            DB::table('rt')->insert([
                'id_usu' => $user->id_usu,
                'id_pub' => $idPublicacion,
                //'fecha' => date('Y-m-d H:i:s'),
            ]);
        });

        return back();
    }

    public function delete($username, $idPublicacion)
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

        //Comprobar si el usuario es el autor de la publicación
        $publication = DB::table('publicacion')->where('id_pub', $idPublicacion)->first();
        if ($publication->autor != $user->id_usu) {
            return back();
        }

        DB::transaction(function () use ($idPublicacion) {
            // Delete the publication and all the comments and retweets
            DB::table('comentario')
                ->where('id_pub', $idPublicacion)
                ->delete();

            DB::table('rt')
                ->where('id_pub', $idPublicacion)
                ->delete();

            DB::table('contenido')
                ->where('id_pub', $idPublicacion)
                ->delete();

            DB::table('publicacion')
                ->where('id_pub', $idPublicacion)
                ->delete();
        });

        return redirect('/' . $username . '/profile');
    }

    public function edit($username, $idPublicacion)
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

        //Comprobar si el usuario es el autor de la publicación
        $publication = DB::table('publicacion')->where('id_pub', $idPublicacion)->first();
        if ($publication->autor != $user->id_usu) {
            return back();
        }

        return view(
            'user.usereditPublication',
            [
                'publicacion' => $publication,
            ]
        );
    }

    public function update($username, $idPublicacion)
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

        //Comprobar si el usuario es el autor de la publicación
        $publication = DB::table('publicacion')->where('id_pub', $idPublicacion)->first();
        if ($publication->autor != $user->id_usu) {
            return back();
        }

        // Validar los datos
        $validator = Validator::make(request()->all(), [
            'descripcion' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        DB::transaction(function () use ($idPublicacion) {
            if (request()->contenido != null) {
                // Save the image from the content of the request into a blob in the database in base64
                $image = request()->file('contenido');
                $image_cont = $image->openFile()->fread($image->getSize());
                DB::table('publicacion')
                    ->where('id_pub', $idPublicacion)
                    ->update([
                        'desc_pub' => request()->descripcion,
                        'cont_pub' => $image_cont,
                    ]);
            } else {
                DB::table('publicacion')
                    ->where('id_pub', $idPublicacion)
                    ->update([
                        'desc_pub' => request()->descripcion,
                    ]);
            }
        });

        return redirect('/' . $username . '/publication/' . $idPublicacion);
    }
}
