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
            $start = strtotime($request['start']);
            $end = strtotime($request['end']);
            
            // $differ = $start - $end / 60*24*60;
            return $differ;
                if($start < $end){
                    $request->validate([
                        'start'=>'required',
                    ]);
                    // return "date is oldest";
                    $insert = Leave::create([
                        'leave_type'=>$request['leave_type'],
                        'start_date'=>$request['start'],
                        'end_date'=>$request['end'],
                        'reason'=>$request['reason'],
                        
                        'emp_id'=>Auth::guard('employee')->user()->id,
                        'slug'=>'leav-'.uniqId(),
                        'created_at'=>Carbon::now(),
                    ]);

                    // Send Mail to Admin
                    // Mail::to('mjrcoder7@gmail.com')->send(new LeaveMailToAdmin($insert));

                    if($insert){
                        Session::flash('success','Submited Your Leave Form!');
                        return redirect()->route('dashboard.leave.view',$insert->slug); 
                    }
                }
                Session::flash('error','Date Is not Correct!');
                return redirect()->route('dashboard.leave.add'); 
        // }

        // Session::flash('error','Already You have Applied');
        // return redirect()->route('dashboard');
    }

    public function view($slug){
        $emp = Employee::where('emp_slug',Auth::guard('employee')->user()->emp_slug)->first();
        $view = Leave::with('employe')->where('emp_id',$emp->id)->first();
        // return $view;
        return view('employe.leave.view',compact('view'));
    } 
}
