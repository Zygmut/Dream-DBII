<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    /**
     * Redireccionamiento de la página de registro
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Comprobar que el usuario está logueado
        if (Session::has('user')) {
            // Si está logueado, redirigir la página principal del usuario {username}
            return redirect('/' . session()->get('user')->nom_usu . '/profile');
        }
        // Si no está logueado, redirigir a la página de registro
        return view('register');
    }

    /**
     * Validación de los datos del formulario de registro
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        // Get the data from the form
        $data = request()->all();

        // Validate the data
        $validation = Validator::make($data, [
            'nombre' => 'required | max:50 | min:3 | regex:/^[a-zA-Z]+$/',
            'apellidos' => 'required | max:255 | regex:/^[a-zA-Z ]+$/',
            'telefono' => 'required | max:9 | min:9 | regex:/^[0-9]+$/',
            'fechaNacimiento' => 'required | date',
            'dni' => 'required | max:9 | min:9 | regex:/[0-9]{8}[a-zA-Z]{1}/',
            'mail' => 'required | email | max:255',
            'nombreUsuario' => 'required | max:255 | min:3 | regex:/^[a-zA-Z0-9]+$/',
            'contrasena' => 'required | max:255 | min:3 | regex:/^[a-zA-Z0-9]+$/',
            'perfil' => 'nullable | image | mimes:jpeg,png,jpg,gif,svg',
        ]);

        // If the validation fails, redirect to the register page
        if ($validation->fails()) {
            return redirect('/register')->withErrors($validation);
        }

        // Comprobar que el nombre de usuario o el mail no está en uso
        if (DB::table('info_usu')->where('nom_usu', $data['nombreUsuario'])->first()) {
            return redirect('/register')->withErrors([
                'nombreUsuario' => 'El nombre de usuario ya está en uso'
            ]);
        }
        if (DB::table('info_usu')->where('mail', $data['mail'])->first()) {
            return redirect('/register')->withErrors([
                'email' => 'El email ya está en uso'
            ]);
        }
        if (DB::table('info_usu')->where('id_usu', $data['dni'])->first()) {
            return redirect('/register')->withErrors([
                'dni' => 'El dni ya está en uso'
            ]);
        }

        DB::beginTransaction();

        // Insertar datos en tabla persona
        DB::table('persona')->insert([
            'dni' => $data['dni'],
            'nom_per' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'telf' => $data['telefono'],
            'nacimiento' => $data['fechaNacimiento'],
        ]);

        $imagePath = public_path("img/default_profile.jpg");
        $image = base64_encode(file_get_contents($imagePath));
        // Insertar datos en tabla usuario
        DB::table('usuario')->insert([
            'id_usu' => $data['dni'],
            'pass' => $data['contrasena'],
            'description' => 'Hola, soy ' . $data['nombreUsuario'],
            'seguidores' => 0,
            'seguidos' => 0,
            'foto_perfil' => null //$image  // Mirar como subir una imagen por defecto a la base de datos
        ]);

        if (request()->perfil != null) {
            $image = request()->file('perfil');
            $image_cont = $image->openFile()->fread($image->getSize());
            DB::table('usuario')
                ->where('id_usu', $data['dni'])
                ->update([
                    'foto_perfil' => $image_cont
                ]);
        }

        // Insertar datos en tabla info_usuario
        DB::table('info_usu')->insert([
            'id_usu' => $data['dni'],
            'nom_usu' => $data['nombreUsuario'],
            'mail' => $data['mail']
        ]);

        DB::commit();

        // Coger user de la base de datos para crear la sesión
        $user = DB::table('usuario')
            ->join('info_usu', 'usuario.id_usu', '=', 'info_usu.id_usu')
            ->where('nom_usu', $data['nombreUsuario'])
            ->where('pass', $data['contrasena'])
            ->first();

        session(['user' => $user]);
        // If the password is correct, redirect to {username} page
        return redirect('/' . $user->nom_usu . '/profile');
    }
}
