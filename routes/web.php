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
    return redirect("/home");
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/stock', 'StockController@stock');

Route::get('/shopping_list', 'ToBuyController@index');

Route::get('/sensors', 'SensorsController@sensors');

Route::get('/recipes', 'RecipesController@recipes');




Route::get('/luminosity', function(){

    $table = Luminosity::all();
    $filename = "luminosity.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('timestamp', 'luminosity'));

    foreach($table as $row) {
        fputcsv($handle, array($row['timestamp'],$row['luminosity']));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );
    return Response::download($filename, 'luminosity.csv', $headers);
});

Route::get('/beacons', function(){

    $table = Beacons::all();
    $filename = "beacons.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('timestamp', 'beacons'));

    foreach($table as $row) {
        fputcsv($handle, array($row['timestamp'],$row['beacons']));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );
    return Response::download($filename, 'luminosity.csv', $headers);
});

Route::get('/weight', function(){

    $table = Weight::all();
    $filename = "weight.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('timestamp', 'weight'));

    foreach($table as $row) {
        fputcsv($handle, array($row['timestamp'],$row['weight']));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );
    return Response::download($filename, 'luminosity.csv', $headers);
});
