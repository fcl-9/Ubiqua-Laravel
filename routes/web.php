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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/stock', 'StockController@stock');

Route::get('/shopping_list', 'HomeController@shopping_list');

Route::get('/sensors', 'HomeController@sensors');

Route::get('/recipes', 'HomeController@recipes');

Route::get('/settings', 'HomeController@settings');


