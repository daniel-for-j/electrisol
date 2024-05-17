<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function profileEdit(Request $request){
        $user = $request->user();

        $validator = $request->validate([
            'profile_picture'=>'required|image|mimes:jpg,png,jpeg,gif,svg'
        ]);

        if($request->name){
            $user->name = $request->name;
            $user->save();

        }
        else if($request->password){
            if($request->password ==$request->confirm_password) {
            $user->password = Hash::make($request->password);
            $user->save();
           
        }
        else {
            return [
                'success'=>false,
                'message'=>'Password does not match'
            ];
        }

        }
        if($request->file('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('images');
            $user->profile_picture = $profilePicturePath;
            $user->save();
        }


        return response()->json([
            'success'=> true,
            'message' => 'Profile Edited Successfully.',
        ]);

        


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
