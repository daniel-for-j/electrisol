<?php

namespace App\Http\Controllers\HiringService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserService;
use App\Models\User;
use App\Models\Category;

class HiringServiceController extends Controller
{
    public function registerService(Request $request) {

        $user = $request->user();

        $userService = $request->validate([
            'profession'=>'required',
            'description'=>'required',
            'phone'=>'required',
            'category_id'=>'required'
        ]);

        $CreateUserService = UserService::create([
            'user_id'=> $user->id,
            'profession'=> $userService['profession'],
            'description'=>$userService['description'],
            'phone'=>$userService['phone'],
            'category_id'=>$userService['category_id']
        ]);

        if($CreateUserService){
            return [
                'success'=> true,
                'message'=>'Service Created Successfully'
            ];
        }        
    }


    public function service(Request $request){
        $services = UserService::get();

        return response()->json([
            'sucess'=>true,
            'message' => 'Services',
            'services'=> $services
        ],200);
    }
}
