<?php

namespace App\Http\Controllers;

use App\Beacons;
use App\Luminosity;
use App\Weight;
use Illuminate\Http\Request;

class SensorsAPIController extends Controller
{
    public function handleBeaconsData(Request $request)
    {
        $timestamp = $request["timestamp"];
        $data = $request["beacons"];
        $beacons = new Beacons();
        $beacons->beacons = $data;
        $beacons->setCreatedAt($timestamp);
        $beacons->save();
    }

    public function handleLuminosityData(Request $request)
    {
        $timestamp = $request["timestamp"];
        $data = $request["beacons"];
        $luminosity = new Luminosity();
        $luminosity->luminosity = $data;
        $luminosity->setCreatedAt($timestamp);
        $luminosity->save();
    }

    public function handleWeightData(Request $request)
    {
        $timestamp = $request["timestamp"];
        $data = $request["weight"];
        $weight = new Weight();
        $weight->weight = $data;
        $weight->setCreatedAt($timestamp);
        $weight->save();
    }
}
