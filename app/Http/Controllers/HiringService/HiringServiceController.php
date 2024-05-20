<?php

namespace App\Http\Controllers\HiringService;

use App\Http\Controllers\Controller;
use App\Models\Device;
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
            'profile_picture'=> $user->profile_picture,
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


    public function services(Request $request){
        $services = UserService::get();
        

        $allServices = [];

        foreach($services as $service){
            $category = Category::where('id',$service->category_id)->first();
            $user = User::where('id', $service->user_id)->first();
            $singleService = [
            'id' => $service->id,
            'user_id' =>$service->user_id,
            'full_name'=>$user->name,
            'category'=>$category->name,
            'description'=>$service->description,
            'profession'=>$service->profession,
            'phone'=>$service->phone
            ];
            array_push($allServices,$singleService);
        }

        return response()->json([
            'sucess'=>true,
            'message' => 'Services',
            'services'=> $allServices
        ],200);
    }

    public function viewService(Request $request, $serviceId){

        $service = UserService::where('id', $serviceId)->first();
        $category = Category::where('id',$service->category_id)->first();
        $user = User::where('id', $service->user_id)->first();

        return response()->json([
            'sucess'=>true,
            'service'=> [
            'id' => $service->id,
            'user_id' =>$service->user_id,
            'full_name'=>$user->name,
            'category'=>$category->name,
            'description'=>$service->description,
            'profession'=>$service->profession,
            'phone'=>$service->phone
            ]
        ],200);


    }
}
