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

$router->group(['prefix' => "/api/v1/userstype", 'namespace' => 'V1'], function () use ($router) {
    $router->get("", "UserTypeController@getAll");
    $router->get("/{id}", "UserTypeController@get");
    $router->post("", "UserTypeController@create");
    $router->put("/{id}", "UserTypeController@update");
    $router->delete("/{id}", "UserTypeController@delete");
});


$router->group(['prefix' => "/api/v1/users", 'namespace' => 'V1'], function () use ($router) {
    $router->post("", "UserController@create");
//    $router->get("", "UserController@getAll");
    $router->get("/{id}", "UserController@get");
    $router->put("/{id}", "UserController@update");
    $router->delete("/{id}", "UserController@delete");
});


$router->group(['prefix' => "/api/v1/transacticion", 'namespace' => 'V1'], function () use ($router) {
    $router->post("", "TransactionsController@create");
//    $router->get("", "TransactionsController@getAll");
//    $router->get("/{id}", "TransactionsController@get");
//    $router->put("/{id}", "TransactionsController@update");
//    $router->delete("/{id}", "TransactionsController@delete");
});
