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

use Illuminate\Http\Request;


$app->get('/',  ['middleware' => 'auth', function (Request $request) {
var_dump($request);
}], function () use ($app) {
    return $app->version();
});

//$app->get('/v1', ['middleware' => 'basic'], function () {  return 'FFFFFFFFFFFFFFFFFF'; });

$app->group(['prefix' => 'api'], function () use ($app) {
    $app->get('/media', 'MediadataController@index');
    $app->get('/media/last', 'MediadataController@lastrecord');
    $app->get('/media/first', 'MediadataController@firstrecord');
    $app->get('/media/freespace', 'MediadataController@freespace');
    $app->get('/media/{id:[0-9]+}', 'MediadataController@show');
    $app->get('/media/size', 'MediadataController@mediasize');
    $app->post('/media', 'MediadataController@create');
    $app->put('/media/{id:[0-9]+}', 'MediadataController@update');
    $app->delete('/media/{id:[0-9]+}', 'MediadataController@destroy');
    $app->post('/media/{media}/upload', 'MediadataController@upload');
});
