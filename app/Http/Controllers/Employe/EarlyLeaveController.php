<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\EarlyLeaveMail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveToAdminNotification;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\EarlyLeave;
use App\Models\LeaveType;
use App\Models\EmployeLeaveSetting;
use App\Models\Employee;
use App\Models\AdminEmail;
use App\Models\User;
use App\Models\OfficeTime;
use Carbon\Carbon;
use Session;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;
use Exception;

class EarlyLeaveController extends Controller
{
    public function index($id){
        $userId = Crypt::decrypt($id);
        
        $leaves = EarlyLeave::where('status','!=',0)->where('emp_id',$userId)->latest('id')->get();
        // return $leaves;
        return view('employe.earlyleave.index',compact('leaves'));
    }
    public function add(){
        $officeTime = OfficeTime::first();
        $leaveType = LeaveType::latest('id')->get();
        return view('employe.earlyleave.add',compact(['leaveType','officeTime']));
    }

    public function insert(Request $request){
        $request->validate([
            'leave_type'=>'required',
            'start'=>'required',
            'others'=>'max:50',
            'detail'=>'required',
        ]);
        $start = Carbon::parse($request->start);
        $sameDate = EarlyLeave::where('emp_id',Auth::user()->id)->whereDay('leave_date',$start->day)->whereMonth('leave_date',$start->month)->whereYear('leave_date',$start->year)->exists();

        if($sameDate){
            Session::flash('error','You Have Already Early Leave On This Day');
            return redirect()->back();
        }

        if($request->start < $request->end){

            $end = Carbon::parse($request->end);
            $duration = $start->diffInMinutes($end);
            // return $totalTime;
            $hours = floor($duration/60);
            $minutes = $duration%60;
            $insert = EarlyLeave::create([
                'emp_id'=>Auth::user()->id,
                'leave_type'=>$request->leave_type,
                'other_type' => $request->leave_type == 0 ? $request->others : null,
                'detail' => $request->detail,
                'leave_date'=>$request->date,
                'start'=>Carbon::parse($request->input('start'),config('app.timezone'))->setTimezone('UTC')->format('H:i'),
                'end'=>Carbon::parse($request->input('end'),config('app.timezone'))->setTimezone('UTC')->format('H:i'),
                'total_hour'=>$duration,
                'unpaid_request'=>$request->unpaid != 0 ? 1 : 0,
                'status'=>1,
                'submit_by'=>Auth::user()->name,
                'created_at'=>Carbon::now('UTC'),
            ]);
          
            $adminEmail = AdminEmail::first();
    
            // if($adminEmail->email_leave == 1){
                
            //     $getEmail = AdminEmail::where('id',1)->first();
            //     $explode = explode(',',$getEmail->email);
            //     foreach($explode as $email){
            //         Mail::to($email)->send(new EarlyLeaveMail($insert));
            //     }
            // }

            if($insert){
                Session::flash('success','You have create a Early Leave Request For '.$hours .' Hours ' . $minutes .' minutes' );
                return redirect()->back();
            }
        }
        else{
            Session::flash('error','Please Insert Right Time To Apply');
            return redirect()->back();
        }
    } 

    public function view($slug){
        $Id = Crypt::decrypt($slug);
        $view = EarlyLeave::with(['employe:id,name'])->where('id',$Id)->first();
        // return $view;
        return view('employe.earlyleave.view',compact('view'));
    }

    public function edit($id){
        $ID = Crypt::decrypt($id);
        $edit= EarlyLeave::where('id',$ID)->first();
        $leaveType = LeaveType::all();
        // return $edit;
        return view('employe.earlyleave.edit',compact(['edit','leaveType']));
    }

    public function update(Request $request){
        $id = $request->id;
        $request->validate([
            'leave_type'=>'required',
            'start'=>'required',
            'others'=>'max:50',
            'detail'=>'required',
        ]);
        $start = Carbon::parse($request->start);
        $sameDate = EarlyLeave::where('id','!=',$id)->where('emp_id',Auth::user()->id)->whereDay('leave_date',$start->day)->whereMonth('leave_date',$start->month)->whereYear('leave_date',$start->year)->exists();

        if($sameDate){
            return "hello";
            Session::flash('error','You Have Already Early Leave On This Day');
            return redirect()->back();
        }

        if($request->start < $request->end){

            $end = Carbon::parse($request->end);
            $duration = $start->diffInMinutes($end);

            $hours = floor($duration/60);
            $minutes = $duration%60;

            $insert = EarlyLeave::where('id',$id)->update([
                'emp_id'=>Auth::user()->id,
                'leave_type'=>$request->leave_type,
                'other_type' => $request->leave_type == 0 ? $request->others : null,
                'detail' => $request->detail,
                'leave_date'=>$request->date,
                'start'=>Carbon::parse($request->input('start'),config('app.timezone'))->setTimezone('UTC')->format('H:i'),
                'end'=>Carbon::parse($request->input('end'),config('app.timezone'))->setTimezone('UTC')->format('H:i'),
                'total_hour'=>$duration,
                'unpaid_request'=>$request->unpaid != 0 ? 1 : 0,
                'status'=>1,
                'submit_by'=>Auth::user()->name,
                'updated_at'=>Carbon::now('UTC'),
            ]);

            if($insert){
                Session::flash('success','You have Updated a Early Leave Request For '.$hours .' Hours ' . $minutes .' minutes' );
                return redirect()->back();
            }
        }
        else{
            Session::flash('error','Please Insert Right Time To Apply');
            return redirect()->back();
        }
    }
}
