<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('/bank', 'Vovo\Controllers\BankController@index');

    $api->post('/bank', 'Vovo\Controllers\BankController@store');

    $api->put('/bank/{bankId}', 'Vovo\Controllers\BankController@update')
    ->where('bankId', '[0-9]+');

    $api->delete('/bank/{bankId}', 'Vovo\Controllers\BankController@delete')
    ->where('bankId', '[0-9]+');
});
