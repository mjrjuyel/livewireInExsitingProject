<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminEmail;
use Carbon\Carbon;
use Session;
use Auth;

class AdminEmailController extends Controller
{
    public function index(){
        $setting = AdminEmail::where('id',1)->first();
        // return $setting;
        return view('superadmin.basic.email.index',compact('setting'));
    }

    public function update(Request $request){

        // return $request->all();
        $request->validate([
            'emailAdd'=>'required',
        ]);

        $update = AdminEmail::where('id',1)->update([
            'email'=>$request['emailAdd'],
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','New Email Change For this Appliaction');
            return redirect()->back();
        }
    }

    public function dailyReportMailActive(Request $request){
       
            $update = AdminEmail::where('id',1)->update([
                'email_report'=>$request->dailyMail,
                'editor'=>Auth::user()->id,
                'updated_at'=>Carbon::now('UTC'),
            ]);
            $active = AdminEmail::first();
            if($active->email_report != ''){
                Session::flash('success','Employee Reports Data Receive On Admin Gmail Activated');
                return redirect()->back();
            }else{
                Session::flash('success','Employee Reports Data Receive On Admin Gmail Deactivated');
                return redirect()->back();
            }
            
        }

    public function dailyLeaveMailActive(Request $request){
       
            $update = AdminEmail::where('id',1)->update([
                'email_leave'=>$request->dailyMail,
                'editor'=>Auth::user()->id,
                'updated_at'=>Carbon::now('UTC'),
            ]);
            $active = AdminEmail::first();
            if($active->email_report != ''){
                Session::flash('success','Leave Request Email Receive On Admin Gmail Activated');
                return redirect()->back();
            }else{
                Session::flash('success','Leave Request Email Receive On Admin Gmail Deactivated');
                return redirect()->back();
            }
            
        }
        
    public function dailySummaryMailActive(Request $request){

            $update = AdminEmail::where('id',1)->update([
                'email_summary'=>$request->dailyMail,
                'editor'=>Auth::user()->id,
                'updated_at'=>Carbon::now('UTC'),
            ]);
            $active = AdminEmail::first();
            if($active->email_report != ''){
                Session::flash('success','Daily Summary To  Admin Gmail Activated');
                return redirect()->back();
            }else{
                Session::flash('success','Daily Summary To Admin Gmail Activated');
                return redirect()->back();
            }
            
    }
    public function deleteReport(Request $request){

            $update = AdminEmail::where('id',1)->update([
                'delete_report'=>$request->deletereport,
                'editor'=>Auth::user()->id,
                'updated_at'=>Carbon::now('UTC'),
            ]);
            $active = AdminEmail::first();
            if($active->delete_report != ''){
                Session::flash('success','Delete 180 days old Daily Report Function is Activated');
                return redirect()->back();
            }else{
                Session::flash('success','Delete 180 days old Daily Report Function is Deactivated');
                return redirect()->back();
            }
            
    }
        
}
