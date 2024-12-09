<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailToAdmin;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;



class LeaveFormController extends Controller
{
    public function add(){
        return view('employe.leave.add');
    }

    public function insert(Request $request){
        
        // return $request->all();
        // $alldata = Leave::where('emp_id',Auth::guard('employee')->user()->id)->latest('id')->first();
        // if($alldata->status != 1 || $alldata->status = null){

            // Convert English date into Unix time stamp 
            $start = strtotime($request['start']);
            $end = strtotime($request['end']);

            // calculate days From Given date
            $differInSecond = $end - $start;
            $days = $differInSecond/86400;

            // return $checkYear;

                // 2 dates are valid or not!
                if($start < $end){

                    // request leave days are more than 3 or not!
                    if($days <= 3){

                        $start_date = Carbon::parse($request->start); // Parsing day in Month, year;

                        // check total Paid of in a month
                        $checkMonth = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('paid_remainig_month');

                        // check total paid off in an annual year
                        $checkYear = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereYear('start_date',$start_date->year)->sum('paid_remaining_year');

                    
                        if($checkYear + $days < 14){
                            // if total day is valid

                            if($checkMonth + $days < 3){
                                // total day is less than request
                                $request->validate([
                                    'start'=>'required',
                                    'end'=>'required',
                                ]);
        
                                $insert = Leave::create([
                                    'leave_type'=>$request['leave_type'],
                                    'start_date'=>Carbon::parse($request->start),
                                    'end_date'=>$request['end'],
                                    'reason'=>$request['reason'],
                                    'total_day'=>$days,
                                    'emp_id'=>Auth::guard('employee')->user()->id,
                                    'slug'=>'leav-'.uniqId(),
                                    'created_at'=>Carbon::now(),
                                ]);
        
                                // Send Mail to Admin
                                // Mail::to('mjrcoder7@gmail.com')->send(new LeaveMailToAdmin($insert));
                                
                                if($insert){
                                    Session::flash('success','Application Sent To SuperAdmin');
                                    return redirect()->route('dashboard.leave.view',$insert->slug); 
                                }
                            }
                            Session::flash('error','Monthly leave limit reached!');
                            return redirect()->route('dashboard.leave.add'); 
                        }
                        Session::flash('error','You have reached out paid leave in an annual year!');
                        return redirect()->route('dashboard.leave.add'); 
                    }
                    Session::flash('error','You cant request more than 3 days!');
                   return redirect()->route('dashboard.leave.add'); 
                }
                Session::flash('error','Date Is not Correct!');
                return redirect()->route('dashboard.leave.add'); 
        // }

        // Session::flash('error','Already You have Applied');
        // return redirect()->route('dashboard');
    }

    public function view($slug){
        $emp = Employee::where('emp_slug',Auth::guard('employee')->user()->emp_slug)->first();
        $view = Leave::with('employe')->where('emp_id',$emp->id)->latest('id')->first();
        // return $view;
        return view('employe.leave.view',compact('view'));
    } 
}
