<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/token',['as'=>'auth.token', 'uses' => 'AuthController@token']);
$router->post('/refresh_token',['as'=>'auth.refresh_token', 'uses' => 'AuthController@refresh_token']);
$router->post('/logout',['as'=>'auth.logout', 'uses' => 'AuthController@logout']);
