<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailToAdmin;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\EmployeLeaveSetting;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;



class LeaveFormController extends Controller
{
    public function add(){
        $leaveType = LeaveType::all();
        return view('employe.leave.add',compact('leaveType'));
    }

    public function insert(Request $request){
        
           $definedLeave = EmployeLeaveSetting::where('id',1)->first();
        // $alldata = Leave::where('emp_id',Auth::guard('employee')->user()->id)->latest('id')->first();
        // if($alldata->status != 1 || $alldata->status = null){

            // Convert English date into Unix time stamp 
            $start = strtotime($request['start']);
            $end = strtotime($request['end']);

            // calculate days From Given date
            $differInSecond = abs($end - $start);
            $days = $differInSecond/86400 + 1;

            // return $days;

                // 2 dates are valid or not!
                if($start <= $end){

                    // Request leave days are more than 3 or not!
                    if($days <= $definedLeave->month_limit){

                        $start_date = Carbon::parse($request->start); // Parsing day in Month, year;

                        // check total Paid of in a month
                        $checkMonth = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('paid_remaining_month');

                        // check total paid off in an annual year
                        $checkYear = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereYear('start_date',$start_date->year)->sum('paid_remaining_year');
                    
                        if($checkYear + $days <= $definedLeave->year_limit){
                            // if total day is valid

                            if($checkMonth + $days <= 3){
                                // total day is less than request
                                $request->validate([
                                    'start'=>'required',
                                    'reason'=>'required',
                                    'end'=>'required',
                                ]);
        
                                $insert = Leave::create([
                                    'leave_type_id'=>$request['leave_type'],
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
        // dd($emp);
        $view = Leave::with(['employe','leavetype'])->where('emp_id',$emp->id)->where('slug',$slug)->first();
        return view('employe.leave.view',compact('view'));
    } 

    public function history($slug){
        $employe = Employee::where('emp_slug',$slug)->first();
        $leavehistory = Leave::where('emp_id',$employe->id)->latest('id')->get();
        // return $leavehistory;
        return view('employe.leave.history',compact('leavehistory'));
    }
}
