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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->post('/device', "DeviceController@handleDeviceRegistration");

Route::middleware('api')->post('/sensors/data', "ProductItemController@handleNewProductsInformation");

Route::middleware('api')->get('/product/name/',"ProductController@getNameNotInBuyList");

Route::middleware('api')->post('/product/{id}/state', "ProductController@handleProductStateChange");

Route::middleware('api')->get('/product_item',"ProductItemController@getItems");

Route::middleware('api')->get('/product_item/{id}',"ProductItemController@getItem");

Route::middleware('api')->post('/sensors/beacons', "SensorsAPIController@handleBeaconsData");

Route::middleware('api')->post('/sensors/luminosity', "SensorsAPIController@handleLuminosityData");

Route::middleware('api')->post('/sensors/weight', "SensorsAPIController@handleWeightData");

Route::middleware('api')->get('/product/', "ProductController@getProducts");