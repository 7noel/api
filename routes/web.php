<?php

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

$router->get('/key', function() {
    return str_random(32);
});

$router->group(['prefix' => 'sunat', 'middleware' => 'cors'], function () use ($router) {
	$router->get('ruc/{ruc}', ['as' => 'ruc', 'uses' => 'ContributorsController@index']);
	$router->get('exchanges_date/{fecha}', ['as' => 'exchangesGetByDay', 'uses' => 'SunatExchangesController@getByDay']);
	$router->get('exchanges_from/{fecha}', ['as' => 'exchangesGetFromDate', 'uses' => 'SunatExchangesController@getFromDate']);
	$router->get('exchanges_month/{month}', ['as' => 'exchangesGetByMonth', 'uses' => 'SunatExchangesController@getByMonth']);
});