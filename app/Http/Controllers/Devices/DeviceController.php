<?php

namespace App\Http\Controllers\Devices;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function listDevices(Request $request){
        $devices = Device::get();

        return $devices;
    }


    public function addDevice(Request $request){

        $device = $request->validate([
            'name'=>'required|string',
            'kilowatt'=>'required',
            'duration'=>'required'
        ]);

        $addDevice = UserDevivce::create([
            'name'=> $device['name'],
            'kilowatt'=> $device['kilowatt'],
            'duration'=> $device['duration'],
            'user_id'=> $request->user()->id,
        ]);


        if($addDevice){
            return [
                'message'=> 'Device added successfully'
            ];
        }

    }

    public function userDevices(Request $request){
        $userDevices = UserDevice::where('user_id',$request->user()->id)->get();

        return $userDevices;
    }
}
