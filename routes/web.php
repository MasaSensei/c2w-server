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

        $router->group(['prefix' => 'codes'], function () use ($router) {
            $router->get('/', 'CodeController@index');
            $router->get('/{id}', 'CodeController@show');
            $router->post('/', 'CodeController@store');
            $router->put('/{id}', 'CodeController@update');
            $router->delete('/{id}', 'CodeController@destroy');
        });

        $router->group(['prefix' => 'colors'], function () use ($router) {
            $router->get('/', 'ColorController@index');
            $router->get('/{id}', 'ColorController@show');
            $router->post('/', 'ColorController@store');
            $router->put('/{id}', 'ColorController@update');
            $router->delete('/{id}', 'ColorController@destroy');
        });

        $router->group(['prefix' => 'models'], function () use ($router) {
            $router->get('/', 'ModelController@index');
            $router->get('/{id}', 'ModelController@show');
            $router->post('/', 'ModelController@store');
            $router->put('/{id}', 'ModelController@update');
            $router->delete('/{id}', 'ModelController@destroy');
        });

        $router->group(['prefix' => 'sizes'], function () use ($router) {
            $router->get('/', 'SizeController@index');
            $router->get('/{id}', 'SizeController@show');
            $router->post('/', 'SizeController@store');
            $router->put('/{id}', 'SizeController@update');
            $router->delete('/{id}', 'SizeController@destroy');
        });

        $router->group(['prefix' => 'categories'], function () use ($router) {
            $router->get('/', 'CategoriesController@index');
            $router->get('/{id}', 'CategoriesController@show');
            $router->post('/', 'CategoriesController@store');
            $router->put('/{id}', 'CategoriesController@update');
            $router->delete('/{id}', 'CategoriesController@delete');
        });

        $router->group(['prefix' => 'bahan-baku'], function () use ($router) {
            $router->get('/', 'BahanBakuController@index');
            $router->get('/{id}', 'BahanBakuController@show');
            $router->post('/', 'BahanBakuController@store');
            $router->put('/{id}', 'BahanBakuController@update');
            $router->delete('/{id}', 'BahanBakuController@destroy');
        });

        $router->group(['prefix' => 'incoming-bahan-baku'], function () use ($router) {
            $router->get('/', 'IncomingBahanBakuController@index');
            $router->get('/{id}', 'IncomingBahanBakuController@show');
            $router->post('/', 'IncomingBahanBakuController@store');
            $router->put('/{id}', 'IncomingBahanBakuController@update');
            $router->delete('/{id}', 'IncomingBahanBakuController@destroy');
        });

        $router->group(['prefix' => 'outgoing-bahan-baku'], function () use ($router) {
            $router->get('/', 'OutgoingBahanBakuController@index');
            $router->get('/{id}', 'OutgoingBahanBakuController@show');
            $router->post('/', 'OutgoingBahanBakuController@store');
            $router->put('/{id}', 'OutgoingBahanBakuController@update');
            $router->delete('/{id}', 'OutgoingBahanBakuController@destroy');
        });

        $router->group(['prefix' => 'workers'], function () use ($router) {
            $router->get('/', 'WorkerController@index');
            $router->get('/{id}', 'WorkerController@show');
            $router->post('/', 'WorkerController@store');
            $router->put('/{id}', 'WorkerController@update');
            $router->delete('/{id}', 'WorkerController@destroy');
        });

        $router->group(['prefix' => 'inventory-bahan-baku-to-cutters'], function () use ($router) {
            $router->get('/', 'InventoryBahanBakuToCuttersController@index');
            $router->get('/{id}', 'InventoryBahanBakuToCuttersController@show');
            $router->post('/', 'InventoryBahanBakuToCuttersController@store');
            $router->put('/{id}', 'InventoryBahanBakuToCuttersController@update');
            $router->delete('/{id}', 'InventoryBahanBakuToCuttersController@destroy');
        });

        $router->group(['prefix' => 'orders-to-cutters'], function () use ($router) {
            $router->get('/', 'OrderBahanBakuController@index');
            $router->get('/{id}', 'OrderBahanBakuController@show');
            $router->post('/', 'OrderBahanBakuController@store');
            $router->put('/{id}', 'OrderBahanBakuController@update');
            $router->delete('/{id}', 'OrderBahanBakuController@destroy');
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
