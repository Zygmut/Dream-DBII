<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'App\Http\Controllers\IndexController@index');

// Register page
Route::get('/register', 'App\Http\Controllers\RegisterController@index');

// Register form
Route::post('/register', 'App\Http\Controllers\RegisterController@register');

// Login page
Route::get('/login', 'App\Http\Controllers\LoginController@index');

// Login form validation
Route::post('/login', 'App\Http\Controllers\LoginController@login');

// User page
Route::get('/{username}/profile', 'App\Http\Controllers\UserController@index');

// User profile edit page
Route::get('{username}/edit', 'App\Http\Controllers\UserController@edit');

// User profile edit form
Route::post('{username}/edit', 'App\Http\Controllers\UserController@update');

// User profile feed
//Route::get('{username}/feed', 'App\Http\Controllers\UserController@feed');

// User profile individual publication
Route::get('{username}/publication/{idPublicacion}', 'App\Http\Controllers\UserController@publication');

// TODO
Route::post('{idUsuario}/comment/newcomment/{idPublicacion}', 'App\Http\Controllers\PublicationController@newComment');

// TODO
Route::get('/{username}/publication/{idPublicacion}/edit', 'App\Http\Controllers\PublicationController@edit');

// Publicaciones de los usuarios que sigue el usuario logueado
Route::get('/{username}', 'App\Http\Controllers\UserFeedController@index');

// Logout
Route::get('/logout', 'App\Http\Controllers\LoginController@logout');

// Create a new publication
Route::post('/publication/new/{idUsuario}', 'App\Http\Controllers\PublicationController@newPublication');

// Create a new publication page
Route::get('/publication/new', 'App\Http\Controllers\PublicationController@index');

// User settings page
Route::get('/{username}/settings', 'App\Http\Controllers\UserSettingsController@index');

// User settings form
Route::post('/{username}/settings', 'App\Http\Controllers\UserSettingsController@update');