<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/swaggerV1', function () {
    return view('swagger');
});

// rota generica para evitar erro de recarga no spa
//https://laravel-news.com/using-vue-router-laravel
Route::get('/app/{any?}', function() {
    return view('app');
})->where('any', '.*')
;