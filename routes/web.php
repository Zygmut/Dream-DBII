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
Route::get('/{username}', 'App\Http\Controllers\User\UserController@index');

// User profile edit page
Route::get('{username}/edit', 'App\Http\Controllers\User\UserController@edit');

// User profile edit form
Route::post('{username}/edit', 'App\Http\Controllers\User\UserController@update');
