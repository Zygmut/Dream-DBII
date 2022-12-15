<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Shmop;
use SNMP;

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

        DB::table('comentario')->insert([
            'id_pub' => $idPublicacion,
            'id_usu' => session()->get('user')->id_usu,
            'cont_com' => request()->comentario,
            'fecha_com' => date('Y-m-d H:i:s'),
        ]);

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

        // Insert into 'publicacion' (idUsuarioAutor, descripcion, contenido, fecha)
        // values (idUsuario, descripcion, contenido, fecha)
        DB::table('publicacion')->insert([
            'autor' => $idUsuario,
            'desc_pub' => request()->descripcion,
            'cont_pub' => $image_cont,
            'fecha_pub' => date('Y-m-d H:i:s'),
        ]);
        //Insert into 'mensaje' y 'receptor' (idUsuarioEmisor, idMensaje, contMensaje, fecha_men == fecha_creacion) (idUsuarioReceptor, idMensaje)
        DB::table('mensaje')->insert([
            'id_usu' => $idUsuario,
            'cont_men' => "Nueva Publicación!",
            'fecha_men' => date('Y-m-d H:i:s'),
        ]);
        return redirect('/' . Session::get('user')->nom_usu . '/profile');
    }
}
