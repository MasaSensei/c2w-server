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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->group(['prefix' => 'suppliers'], function () use ($router) {
            $router->get('/', 'SuppliersController@index');
            $router->get('/{id}', 'SuppliersController@show');
            $router->post('/', 'SuppliersController@store');
            $router->put('/{id}', 'SuppliersController@update');
            $router->delete('/{id}', 'SuppliersController@destroy');
        });
    });
});

$router->options('/{any:.*}', function () {
    return response()->json([], 204, [
        'Access-Control-Allow-Origin'      => '*',
        'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
        'Access-Control-Allow-Credentials' => 'true',
    ]);
});
