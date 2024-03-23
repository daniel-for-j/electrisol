<?php

namespace App\Http\Controllers\ReportUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reports;



class ReportController extends Controller
{

    public function report(Request $request){
        $user= $request->user();


        $report = $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'location'=>'required|string',
            'affected_disco'=>'required|string',
            'company_name'=>'required|string',
            'phone_no'=>'required|string',
        ]);
        $createReport = Reports::create([
            'name'=> $report['name'],
            'report_desc'=>$report['description'],
            'location'=>$report['location'],
            'affected_disco'=>$report['affected_disco'],
            'company_name'=>$report['company_name'],
            'phone_no'=>$report['phone_no'],
            'email'=>$user->email,
            'user_id'=>$user->id
        ]);

        if($createReport){
            return [
                'messgae'=>'Report sent'
            ];
        }


    }


    public function reportHistory(Request $request){
        $user = $request->user();

        $reportHistory = Reports::where('user_id',$user->id)->get();

        // To format created_at
        // $date = new DateTime($reportHistory->created_at);
        // $formattedDate = $date->format('M j Y');

        return [
        'message'=>'Report History',
        'report_history'=>$reportHistory

        ];
    }
    public function singleReport(Request $request,$reportId){

        $user = $request->user();
        $singleReport = Reports::where('id', $reportId)->first();
        
        if($user->id == $singleReport->user_id){
            return [
                'message'=> 'Single Report',
                'single_report'=> $singleReport
            ];
        }
        else {
            return [
                'message'=> 'This user does not have access to this report'
            ];
        }

       
    }
}
