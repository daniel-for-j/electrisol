<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\PHPMailMailer;
use PHPMailer\PHPMailer\PHPMailer;
use Session;
use Mail;

class AuthController extends Controller
{
    public function register(Request $request){


        $registerUserData = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        if($user){
        // OTP creation
        $otp = rand(100000, 999999);
        $details = array(
            "otp" => $otp
        );
        
        Session::put('to', $request->email);
        Session::put('from', 'vigo4real2016@gmail.com');

        Mail::send('emails.email-verification', $details, function ($message) {
            $message->from(Session::get('from'), 'Electrisol');
            $message->to(Session::get('to'));
            $message->subject('OTP');
        });

    

        $user->remember_token = $otp;
        $user->save();

        }
        

        

        return response()->json([
            'message' => 'One Time Password(OTP) has been sent to your email',
            'token_duartion' => '1 Hour',
            'otp'=>$otp
        ]);
    }


    public function login(Request $request){
        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ],401);
        }
        elseif(!Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Password does not match'
            ],401);
        }
        elseif(is_null($user->email_verified_at)){
            return response()->json([
                'message' => 'User not yet verified'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'message' => 'Login Successful',
            'access_token' => $token,
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
    
        return response()->json([
          "message"=>"Logged Out"
        ]);
    }

    public function getOtp(Request $request){

        $request->validate([
            'email'=>'required|string|email',
        ]);

        $otp = rand(100000, 999999);
        $details = array(
            "otp" => $otp
        );
       
        Session::put('to', $request->email);
        Session::put('from', 'vigo4real2016@gmail.com');

        Mail::send('emails.otp', $details, function ($message) {
            $message->from(Session::get('from'), 'Electrisol');
            $message->to(Session::get('to'));
            $message->subject('OTP');
        });

        // Save sent otp 
        $user = User::where('email', $request->email)->first();
        $user->remember_token = $otp;
        $user->save();




        return 
        [
            'message'=>"OTP has been sent to your Email"
        ];

    }

    public function verifyOtp(Request $request){


        $request->validate([
            'email'=>'required|string|email',
            'otp'=>'required'
        ]);

        // User verifying
        $user = User::where('email', $request->email)->first();

        if($user->remember_token == $request->otp){
            $user->email_verified_at = time();
            $user->save();
        }
        else{
            return [
                'message'=>'Sorry, OTP(One Time Password) does not match'
            ];
        }

        return [
            'message'=>'User Verified Successfully'
        ];
        
    }

    public function resetPassword(Request $request){

        $request->validate([
            'otp'=>'required',
            'password'=>'required',
            'confirm_password'=>'required'
        ]);

        $otp = User::where('remember_token',$request->otp)->first();

        if($otp){
            if($request->password == $request->confirm_password){
                $otp->password = Hash::make($request->password);
                $otp->save();

                return response()->json([
                    'message' => 'Password reset successful.',
                ]);


            }
            else {
                return [
                    'message'=>'Password does not match'
                ];
            }

        }
        else {
            return [
                'message'=>'Sorry, OTP(One Time Password) does not match'
            ];
        }

    }

    public function changePassword(Request $request){

        $user= $request->user();

        $request->validate([
            'password'=>'required',
            'confirm_password'=>'required'
        ]);

        if($request->password == $request->confirm_password){
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'message' => 'Password changed successfully.',
            ]);


        }
        else {
            return [
                'message'=>'Password does not match'
            ];
        }

    }
}
