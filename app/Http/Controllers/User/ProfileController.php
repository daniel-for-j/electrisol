<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profileEdit(Request $request){
        $user = $request->user();

        if($request->name){

        }
        else if($request->phone){

        }
        


    }

    public function profilePictureUpload(Request $request){
        $user = $request->user();

        $profilePicturePath = $request->file('profile_picture')->store('images');

        $user->profile_picture = $profilePicturePath;
        $savePicture = $user->save();
        

        
        return response()->json([
            'success'=> true,
            'message'=> 'Profile Picture Uploaded',
        ],200);



    }
}
