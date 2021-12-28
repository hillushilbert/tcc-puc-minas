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
    return response('Unauthorized.',403);
});

// $router->group(['middleware' => ['accept_json','auth']], function () use ($router) {
    $router->get('/clientes',['as'=>'clientes.index', 'uses' => 'ClientesController@index']);
    $router->get('/clientes/{id}',['as'=>'clientes.index', 'uses' => 'ClientesController@show']);
    $router->put('/clientes/{id}',['as'=>'clientes.index', 'uses' => 'ClientesController@update']);
    $router->post('/clientes',['as'=>'clientes.store', 'uses' => 'ClientesController@store']);
// });
