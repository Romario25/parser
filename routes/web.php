<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', 'TestController@index');

Route::get('test-proxy', 'TestController@testProxy');

Route::get('register/confirm/{token}', 'Auth\RegisterController@confirm');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/', 'HomeController@index');

Route::get('/user', 'UserController@listUsers');

Route::get('/user/add', 'UserController@addForm');

Route::post('/user/add', ['uses' => 'UserController@add', 'as' => 'add-user']);

Route::match(['get', 'post', 'delete'], '/user/edit-user/{id}', ['uses' => 'UserController@update', 'as' => 'edit-user']);

Route::match(['get', 'post'],'/proxy/add', ['uses' => 'ProxyController@add', 'as' => 'proxy-add']);

Route::match(['get', 'post', 'delete'], '/proxy/update/{id}', ['uses' => 'ProxyController@update', 'as' => 'proxy-update']);

Route::get('login-admin',['uses' => 'Auth\AdminLoginController@showLoginForm', 'as' => 'admin-login']);
Route::post('login-admin',['uses' => 'Auth\AdminLoginController@login']);