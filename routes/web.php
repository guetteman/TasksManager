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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->post('auth/login', 'AuthController@postLogin');

$app->group(['prefix' => 'admin'], function () use ($app) {
  $app->get('users', 'UsersController@index');
  $app->post('users', 'UsersController@store');
  $app->get('users/{id}', 'UsersController@show');
  $app->put('users/{id}', 'UsersController@update');
  $app->delete('users/{id}', 'UsersController@destroy');
});
