<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Index page
Route::get('/', function () {
    return view('index');
});

// Register page
Route::get('/register', function () {
    return view('register');
});

// Route to register a new user
Route::post('/register', function () {
    // Get the data from the form
    $data = request()->all();
    // Validate the data
    $validation = Validator::make($data, [
        'nombre' => 'required',
        'apellidos' => 'required',
        'username' => 'required',
        'password' => 'required'
    ]);
    // If the validation fails, redirect to the register page
    if ($validation->fails()) {
        return redirect('/register')->withErrors($validation);
    }
    // Insert the user into the database
    DB::table('users')->insert([
        'nombre' => $data['nombre'],
        'apellidos' => $data['apellidos'],
        'username' => $data['username'],
        'password' => $data['password']
    ]);
    // If the validation succeeds, redirect to the login page and show a success message
    return redirect('/login')->with('success', 'Usuario registrado correctamente');
});

// Login page
Route::get('/login', function () {
    return view('login');
});

// Login form (validate the user)
Route::post('/login', function () {
    // Get username and password from the form
    $data = request()->all();
    // Validate the data
    $validation = Validator::make($data, [
        'username' => 'required',
        'password' => 'required'
    ]);
    // If the validation fails, redirect to the login page
    if ($validation->fails()) {
        return redirect('/login')->withErrors($validation);
    }
    // Get the user from the database
    $user = DB::table('users')->where('username', $data['username'])->first();
    // If the user does not exist, redirect to the login page and show an error message
    if (!$user) {
        return redirect('/login')->with('error', 'El usuario no existe');
    }
    // If the user exists, check if the password is correct
    if ($user->password != $data['password']) {
        return redirect('/login')->with('error', 'La contraseña es incorrecta');
    }
    // If the password is correct, redirect to the home page
    return redirect('/home');
});
