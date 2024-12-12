<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Employee;
use App\Models\DailyReport;
use Carbon\Carbon;
use Session;
use Auth;

class DailyReportController extends Controller
{
    public function index(){
        $alldata = DailyReport::with('employe')->where('submit_by',Auth::guard('employee')->user()->id)->where('status',1)->get();
        return view('employe.dailyreport.index',compact('alldata'));
    }

    public function add(){
        $employe = Employee::where('emp_status',1)->latest('id')->get();
        return view('employe.dailyreport.add',compact('employe'));
    }

    public function submit(Request $request){

        //Check that is There any chances to Same Date  
        $submitDate = Carbon::parse($request->submit_date);
        $checkDate=DailyReport::where('status',1)->whereDay('submit_date',$submitDate->day)->whereMonth('submit_date',$submitDate->month)->count();

        // return $request->all();
        if($checkDate == null || $checkDate == 0){
            // return 'In If Condition';

            $presentDay = strtotime('now');
            $submit = strtotime($request->submit_date);
            // echo  $presentDay;
            if($presentDay >= $submit){
                
                // check 3 Days before in second
                $maximumPreviousDate = strtotime('-3 days',$presentDay);

                if($maximumPreviousDate <= $submit){

                    // return "3 day after";
                    $request->validate([
                        'name'=>'required',
                        'submit_date'=>'required',
                        'detail'=>'required',
                    ]);
        
                    $insert= DailyReport::create([
                        'submit_by'=>$request['name'],
                        'submit_date'=>$request['submit_date'],
                        'detail'=>$request['detail'],
                        'slug'=>'report-'.uniqId(),
                        'created_at'=>Carbon::now(),
                    ]);
        
                    if($insert){
                        Session::flash('success','Daily Report Submited');
                        return redirect()->back();
                    }
                }else{
                    // return "3 days Before";
                    Session::flash('error','You can not Submit report 3 Days before From Current Day!');
                    return redirect()->back();
                }
                
            }else{
                Session::flash('error','The Date is not come yet!');
                return redirect()->back();
            }
        }else{
            // return "Else";
            Session::flash('error','Already You have Submitted on This day!');
            return redirect()->back();
        }
        
    }

    public function view($slug){
        // fetch data from designation table
        $view = DailyReport::with('employe.emp_desig')->where('slug',$slug)->first();
        // return $view;
        return view('employe.dailyreport.view',compact('view'));
    }
}
