<?php

namespace App\Http\Controllers;

use App\Beacons;
use App\Luminosity;
use App\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SensorsAPIController extends Controller
{
    public function handleBeaconsData(Request $request)
    {
        $request = $request->json()->all();
        $timestamp = $request["timestamp"];
        $data = $request["beacons"];
        $beacons = new Beacons();
        $beacons->beacons = $data;
        $beacons->setCreatedAt($timestamp);
        $beacons->save();
    }

    public function handleLuminosityData(Request $request)
    {
        $request = $request->json()->all();
        $timestamp = $request["timestamp"];
        $data = $request["luminosity"];
        $luminosity = new Luminosity();
        $luminosity->luminosity = $data;
        $luminosity->setCreatedAt($timestamp);
        $luminosity->save();
    }

    public function handleWeightData(Request $request)
    {
        $request = $request->json()->all();
        $timestamp = $request["timestamp"];
        $data = $request["weight"];
        $weight = new Weight();
        $weight->weight = $data;
        $weight->setCreatedAt($timestamp);
        $weight->save();
    }



public function Luminosity(){

    $table = Luminosity::all();
    $filename = "luminosity.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('created_at', 'luminosity'));

    foreach($table as $row) {
        fputcsv($handle, array($row['created_at'],$row['luminosity']));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );
    return Response::download($filename, 'luminosity.csv', $headers);
}

public function Beacons(){

    $table = Beacons::all();
    $filename = "beacons.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('created_at', 'beacons'));

    foreach($table as $row) {
        fputcsv($handle, array($row['created_at'],$row['beacons']));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );
    return Response::download($filename, 'beacons.csv', $headers);
}

public function Weight(){

    $table = Weight::all();
    $filename = "weight.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('created_at', 'weight'));

    foreach($table as $row) {
        fputcsv($handle, array($row['created_at'],$row['weight']));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );
    return Response::download($filename, 'weight.csv', $headers);
}


}
