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

        return [
            'message'=>'Device List',
            'devices'=> $devices
        ];
    }


    public function addDevice(Request $request){

        $device = $request->validate([
            'name'=>'required|string',
            'kilowatt'=>'required',
            'duration'=>'required'
        ]);

        // To get Device name
        $addedDevice = Device::where('code_name',$device['name'])->first();

        $addDevice = UserDevice::create([
            'user_id'=>  $request->user()->id,
            'name'=> $addedDevice->name,
            'kilowatt'=> $device['kilowatt'],
            'duration'=> $device['duration'],
            'code_name'=> $device['name']
        ]);


        if($addDevice){
            return [
                'message'=> 'Device added successfully'
            ];
        }

    }

    public function userDevices(Request $request){
        $userDevices = UserDevice::where('user_id',$request->user()->id)->get();
        if(count($userDevices)==0){
            return [
                'message'=> "No devices added yet"
            ];
        }

        return[
            'mesage'=>'Your devices',
            'devices'=> $userDevices
        ];
    }
}
