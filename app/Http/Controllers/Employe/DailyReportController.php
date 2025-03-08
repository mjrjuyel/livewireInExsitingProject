<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Employee;
use App\Models\DailyReport;
use App\Models\OfficeTime;
use App\Models\AdminEmail;
use Carbon\Carbon;
use Session;
use Auth;

class DailyReportController extends Controller
{
    public function index(){
        $alldata = DailyReport::with('employe')->where('submit_by',Auth::user()->id)->where('status',1)->latest('submit_date')->get();
        // return $alldata->count('id');
        return view('employe.dailyreport.index',compact('alldata'));
    }

    public function add(){
        $officeTime = OfficeTime::first();
        return view('employe.dailyreport.add',compact('officeTime'));
    }

    public function submit(Request $request){

        $request->validate([
            'name'=>'required',
            'submit_date'=>'required',
            'detail'=>'required',
        ]);

        //Check that is There any chances to Same Date  
        $submitDate = Carbon::parse($request->submit_date);
        $checkDate=DailyReport::where('status',1)->where('submit_by',Auth::user()->id)->whereDay('submit_date',$submitDate->day)->whereMonth('submit_date',$submitDate->month)->count();

        // return $request->all();
        if($checkDate == null || $checkDate == 0){
            // return 'In If Condition';

            $presentDay = strtotime('now');
            $submit = strtotime($request->submit_date);

            if($presentDay >= $submit){
                
                // check 3 Days before in second
                $maximumPreviousDate = strtotime('-3 days',$presentDay);

                if($maximumPreviousDate <= $submit){

                    $insert = DailyReport::create([
                        'submit_by'=>$request['name'],
                        'submit_date'=>Carbon::parse($request['submit_date'])->addHours(6),
                        'detail'=>$request['detail'],
                        'check_in'=>Carbon::parse($request->input('checkin'), config('app.timezone'))->setTimezone('UTC')->format('H:i'),
                        'check_out'=>Carbon::parse($request->input('checkout'), config('app.timezone'))->setTimezone('UTC')->format('H:i'),
                        'created_at'=>Carbon::now('UTC'),
                    ]);
                  
                    $email = AdminEmail::where('id',1)->first();
                    if($email->email_report == 1){
                        $explode = explode(',',$email->email);
                        foreach($explode as $emai){
                            Mail::to($emai)->send(new DailyReportMail($insert));
                        }
                    }
        
                    if($insert){
                        Session::flash('success','Daily Report Submitted');
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

    public function edit($slug){
        $id = Crypt::decrypt($slug);
        $edit = DailyReport::where('id',$id)->first();
        return view('employe.dailyreport.edit',compact('edit'));
    }

    public function update(Request $request){
        $id = $request->id;
        // return $id;
        $request->validate([
            'detail'=>'required',
        ]);  
        
        // return $request->all();
        $insert= DailyReport::where('id',$id)->update([
            'check_in'=>Carbon::parse($request->input('checkin'), config('app.timezone'))->setTimezone('UTC')->format('H:i'),
            'check_out'=>Carbon::parse($request->input('checkout'), config('app.timezone'))->setTimezone('UTC')->format('H:i'),
            'detail'=>$request['detail'],
            'updated_at'=>Carbon::now('UTC'),
        ]);
        
        if($insert){
            Session::flash('success','Updated Daily Report Details');
            return redirect()->back();
        }
        
    }

    public function view($slug){
        $id = Crypt::decrypt($slug);
        // fetch data from designation table
        $view = DailyReport::with('employe')->where('id',$id)->first();
        // return $view;
        return view('employe.dailyreport.view',compact('view'));
    }
}
