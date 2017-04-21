<?php
/**
 * Created by PhpStorm.
 * User: vmcb
 * Date: 14-04-2017
 * Time: 18:44
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;

class DeviceController extends Controller
{
    private function insertDevice($name)
    {
        $device = new Device();
        $device->device_name = $name;
        $device->save();
        return $device;

    }

    private function getDeviceId($name)
    {
        $device = Device::where("device_name",$name)->first();
        if (is_null($device)) {
            return $this->insertDevice($name)->id;
        }
        else {
            return $device->id;
        }
    }

    public function handleDeviceRegistration(Request $request)
    {
        $name = $request->json()->all()["device_name"];
        return response()->json(["id" => $this->getDeviceId($name)]);
    }
}