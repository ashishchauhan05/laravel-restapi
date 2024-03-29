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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/index', 'HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function() {

    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');

    Route::get('/','DashboardController@index');
    Route::get('unauthorized','DashboardController@unauthorized'); 

});