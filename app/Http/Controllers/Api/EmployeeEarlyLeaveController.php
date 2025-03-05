<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EarlyLeaveMail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveToAdminNotification;
use Illuminate\Support\Facades\Validator;
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

class EmployeeEarlyLeaveController extends Controller
{
    public function index(){
        try{
            $leaves = EarlyLeave::where('status','!=',0)->where('emp_id',Auth::user()->id)->latest('id')->get();
        return response()->json([
            'status'=>true,
            'Message'=>'All of My Early Leave History. Total number is : ' . $leaves->count(),
            'data'=>$leaves,
        ],200);
        }
        catch(Exception $e){
            return reponse()->json([
            'status'=>true,
            'Message'=>'Failed To Fetch Early Leave history',
            'data'=>$e->getMessage(),
            ],201);
        }
    }
    public function time(){
        try{
            $officeTime = OfficeTime::first(['office_start','office_end']);
            $leaveType = LeaveType::get(['id','type_title']);
            return response()->json([
                'status'=>true,
                'message'=>'Leave Type and Office time Showing dynamic',
                'leaveType'=>$leaveType,
                'officeTime' =>$officeTime,
            ],200);
        }catch(Exception $e){
            return reponse()->json([
            'status'=>true,
            'Message'=>'Failed To Fetch Early Leaves Credentials',
            'data'=>$e->getMessage(),
            ],201);
        }
    }

    public function insert(Request $request){
       
        $validator=Validator::make($request->all(),[
            'leave_type'=>'required',
            'start'=>'required',
            'others'=>'max:50',
            'detail'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>true,
                'message'=>"Unsuccesful To Inser!",
                'Error-Message'=>$validator->errors(), 
            ]);
        }

        $date = Carbon::parse($request->date);
        $sameDate = EarlyLeave::where('emp_id',Auth::user()->id)->whereDay('leave_date',$date->day)->whereMonth('leave_date',$date->month)->whereYear('leave_date',$date->year)->exists();

        if($sameDate){
            return response()->json([
                'status'=>true,
                'message'=>'Already you have taken early leave on this day!'
            ],201);
        }

        
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
            $duration = $start->diffInMinutes($end);
            // return $totalTime;
            $hours = floor($duration/60);
            $minutes = $duration%60;
            if($hours >= 0 && $minutes >= 0){
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
        
                if($adminEmail->email_leave == 1){
                    $getEmail = AdminEmail::where('id',1)->first();
                    $explode = explode(',',$getEmail->email);
                    foreach($explode as $email){
                        Mail::to($email)->send(new EarlyLeaveMail($insert));
                    }
                }

                if($insert){
                    return response()->json([
                        'status'=>true,
                        'message'=>'You have create a Early Leave Request For ' .$hours .' hours ' . $minutes .' minutes' ,
                    ],200);
                }
            }
            else{
                Session::flash('error','Please Insert Right Time To Apply');
                return response()->json([
                    'status'=>true,
                    'message'=>'Please Insert Right Time To Apply',
                ],201);
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
        $validator=Validator::make($request->all(),[
            'leave_type'=>'required',
            'start'=>'required',
            'others'=>'max:50',
            'detail'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>true,
                'message'=>"Unsuccesful To Inser!",
                'Error-Message'=>$validator->errors(), 
            ]);
        }
        $date = Carbon::parse($request->date);
        $sameDate = EarlyLeave::where('id','!=',$id)->where('emp_id',Auth::user()->id)->whereDay('leave_date',$date->day)->whereMonth('leave_date',$date->month)->whereYear('leave_date',$date->year)->exists();

        if($sameDate){
            dd('sameDate');
            return response()->json([
                'status'=>true,
                'message'=>'You Have Already Early Leave On This Day',
            ],200);
        }

        
            
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
            
            $duration = $start->diffInMinutes($end);
            $hours = floor($duration/60);
            $minutes = $duration%60;

            if($hours >= 0 && $minutes >= 0){
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
                    return response()->json([
                        'status'=>true,
                        'message'=>'You have Updated a Early Leave Request For ' . $hours .' Hours ' . $minutes .' minutes' ,
                    ],200);
                }
            }
            else{
                return response()->json([
                    'status'=>true,
                    'message'=>'Please Insert Right Time ',
                ],200);
            }
    }
}
