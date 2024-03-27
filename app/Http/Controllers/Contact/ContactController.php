<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function contactUs(Request $request){


        $contactValidator = $request->validate([
            'message'=>'required|string',
            'company_name'=>'required|string',
            'phone_no'=>'required',

        ]);


        $contact = Contact::create([
            'full_name'=> $request->user()->name,
            'message'=>$contactValidator['message'],
            'company_name'=>$contactValidator['company_name'],
            'phone_no'=>$contactValidator['phone_no'],
            'email'=> $request->user()->email,

        ]);

        if($contact){
            return [
                'success'=> true,
                'message'=>'Sent Successful',
            ];
        }
    }

    public function contactReports(Request $request){
        
    }
}
