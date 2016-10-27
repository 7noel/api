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
$app->get('/padron/ruc/{ruc}', ['middleware' => 'cors', 'as' => 'ruc', 'uses' => 'ContributorsController@index']);
$app->get('/exchanges/date/{fecha}', ['middleware' => 'cors', 'as' => 'exchangesGetByDay', 'uses' => 'SunatExchangesController@getByDay']);
$app->get('/exchanges/month/{month}', ['middleware' => 'cors', 'as' => 'exchangesGetByMonth', 'uses' => 'SunatExchangesController@getByMonth']);
