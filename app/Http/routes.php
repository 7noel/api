<?php
use App\Contributor;
use App\User;

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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'sunat', 'middleware' => 'cors'], function () use ($app) {
	$app->get('ruc/{ruc}', ['as' => 'ruc', 'uses' => 'ContributorsController@index']);
	$app->get('exchanges_date/{fecha}', ['as' => 'exchangesGetByDay', 'uses' => 'SunatExchangesController@getByDay']);
	$app->get('exchanges_from/{fecha}', ['as' => 'exchangesGetFromDate', 'uses' => 'SunatExchangesController@getFromDate']);
	$app->get('exchanges_month/{month}', ['as' => 'exchangesGetByMonth', 'uses' => 'SunatExchangesController@getByMonth']);
	//$app->get('exchanges_from/{date}', ['as' => 'exchangesGetFromDate', 'uses' => 'SunatExchangesController@getFromDate']);
});