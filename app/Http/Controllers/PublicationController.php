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
        $username = Session::get('user')->nombreUsuario;

        //Comprobar si el usuario existe
        $user = DB::table('info_usuario')->where('nombreUsuario', $username)->first();
        if (!$user) {
            return redirect('/login');
        }

        return view('newpublication');
    }

    public function newcommet($idUsuario, $idPublicacion)
    {
        // TODO: Implementar
    }

    public function newPublication($idUsuario)
    {
        // Comprobamos que el usuario esté logueado
        if (!Session::has('user')) {
            return redirect('/login');
        }

        // Comprobamos que el usuario que está intentando crear una publicación es el mismo que está logueado
        if (Session::get('user')->idUsuario != $idUsuario) {
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

        // NO FUNCIONA, FALTA SOLUCIONAR COMO OBTENER LA IMAGEN Y GURADARLA EN BASE64
        
        // Save the image from the content of the request into a blob in the database in base64
        $image = request()->file('contenido');
        $base64 = base64_encode($image->getContent());
        

        // Insert into 'publicacion' (idUsuarioAutor, descripcion, contenido, fecha)
        // values (idUsuario, descripcion, contenido, fecha)
        DB::table('publicacion')->insert([
            'idUsuarioAutor' => $idUsuario,
            'descripcion' => request()->descripcion,
            'contenido' => $base64,
            'fecha' => date('Y-m-d H:i:s'),
        ]);

        return redirect('/' . Session::get('user')->nombreUsuario . '/profile');
    }
}
