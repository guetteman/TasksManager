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

$app->group(['prefix' => 'admin', 'middleware' => ['auth', 'checkAdmin']], function () use ($app) {

  $app->get('/', function () {
    return redirect('admin/dashboard');
  });

  $app->get('dashboard', 'Admin\AdminController@index');

  $app->get('users', 'Admin\UsersController@index');
  $app->post('users', 'Admin\UsersController@store');
  $app->get('users/{id}', 'Admin\UsersController@show');
  $app->put('users/{id}', 'Admin\UsersController@update');
  $app->delete('users/{id}', 'Admin\UsersController@destroy');

  $app->get('tasks', 'Admin\TasksController@index');
  $app->post('tasks', 'Admin\TasksController@store');
  $app->get('tasks/{id}', 'Admin\TasksController@show');
  $app->put('tasks/{id}', 'Admin\TasksController@update');
  $app->delete('tasks/{id}', 'Admin\TasksController@destroy');

  $app->get('priorities', 'Admin\PrioritiesController@index');
  $app->post('priorities', 'Admin\PrioritiesController@store');
  $app->get('priorities/{id}', 'Admin\PrioritiesController@show');
  $app->put('priorities/{id}', 'Admin\PrioritiesController@update');
  $app->delete('priorities/{id}', 'Admin\PrioritiesController@destroy');


});
