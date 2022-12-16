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

// User profile individual publication
Route::get('/{username}/publication/{idPublicacion}', 'App\Http\Controllers\UserController@publication');

// New comment form
Route::post('/{idUsuario}/comment/newcomment/{idPublicacion}', 'App\Http\Controllers\PublicationController@newcomment');

// Edit a publication
Route::get('/{username}/publication/{idPublicacion}/edit', 'App\Http\Controllers\PublicationController@edit');

// Edit a publication form
Route::post('/{username}/publication/{idPublicacion}/edit', 'App\Http\Controllers\PublicationController@update');

// Publicaciones de los usuarios que sigue el usuario logueado
Route::get('/{username}', 'App\Http\Controllers\UserFeedController@index');

// Logout
Route::get('/{username}/logout', 'App\Http\Controllers\LoginController@logout');

// Create a new publication
Route::post('/publication/new/{idUsuario}', 'App\Http\Controllers\PublicationController@newPublication');

// Create a new publication page
Route::get('/publication/new', 'App\Http\Controllers\PublicationController@index');

// Create a new history
Route::post('/history/new/{idUsuario}', 'App\Http\Controllers\HistoryController@newHistory');

// Create a new history page
Route::get('/history/new', 'App\Http\Controllers\HistoryController@index');

// User settings page
Route::get('/{username}/settings', 'App\Http\Controllers\UserSettingsController@index');

// User settings form
Route::post('/{username}/settings', 'App\Http\Controllers\UserSettingsController@update');

// User notifications page !(TODO)
Route::get('/{username}/notifications', 'App\Http\Controllers\UserNotificationsController@index');

// User search page
Route::get('/{username}/search', 'App\Http\Controllers\UserSearchController@index');

// Follow user
Route::post('/{username}/follow/{usernamefollow}', 'App\Http\Controllers\UserController@follow');

// Unfollow user
Route::post('/{username}/unfollow/{usernameunfollow}', 'App\Http\Controllers\UserController@unfollow');

// Stories page
Route::get('/{username}/story/{idHistoria}', 'App\Http\Controllers\HistoryController@viewHistory');

// Stories page edit
Route::get('/{username}/story/{idHistoria}/edit', 'App\Http\Controllers\HistoryController@editHistory');

// Stories page edit form
Route::post('/{username}/story/{idHistoria}/edit', 'App\Http\Controllers\HistoryController@updateHistory');

// Stories page delete
Route::post('/{username}/story/{idHistoria}/delete', 'App\Http\Controllers\HistoryController@deleteHistory');

// Rt a publication
Route::post('/{username}/rt/{idPublicacion}', 'App\Http\Controllers\PublicationController@rt');

// Delete a publication
Route::post('/{username}/publication/{idPublicacion}/delete', 'App\Http\Controllers\PublicationController@delete');

// See all users that follow the user
Route::get('/{username}/followers', 'App\Http\Controllers\UserController@followers');

// See all users that the user follows
Route::get('/{username}/following', 'App\Http\Controllers\UserController@following');

// Delete an account
Route::post('/{username}/account/delete', 'App\Http\Controllers\UserController@deleteAccount');
