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

    Route::post('login', '\Vovo\Controllers\AuthController@login');
    Route::post('logout', '\Vovo\Controllers\AuthController@logout');
    Route::post('refresh', '\Vovo\Controllers\AuthController@refresh');
    Route::post('me', '\Vovo\Controllers\AuthController@me');
    $api->post('/user', 'Vovo\Controllers\UserController@store');

    $api->group(['middleware' => 'auth.jwt'], function ($api) {
        $api->get('/bank', 'Vovo\Controllers\BankController@index');

        $api->post('/bank', 'Vovo\Controllers\BankController@store');

        $api->put('/bank/{bankId}', 'Vovo\Controllers\BankController@update')
        ->where('bankId', '[0-9]+');

        $api->delete('/bank/{bankId}', 'Vovo\Controllers\BankController@delete')
        ->where('bankId', '[0-9]+');

        $api->put('user/{userId}', 'Vovo\Controllers\UserController@update')
        ->where('userId', '[0-9]+');

        $api->delete('user/{userId}', 'Vovo\Controllers\UserController@delete')
        ->where('userId', '[0-9]+');

        $api->get('user', 'Vovo\Controllers\UserController@index');
    });
});
