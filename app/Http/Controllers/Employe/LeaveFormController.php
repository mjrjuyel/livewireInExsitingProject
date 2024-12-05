<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailToAdmin;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;



class LeaveFormController extends Controller
{
    public function add(){
        return view('admin.leave.add');
    }

    public function insert(Request $request){
        // return $request->all();
        $alldata = Leave::where('user_id',Auth::user()->id)->count();
        if($alldata < 1){
            $start = strtotime($request['start']);
            $end = strtotime($request['end']);
                
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
                        'user_id'=>Auth::user()->id,
                        'slug'=>'leav-'.uniqId(),
                        'created_at'=>Carbon::now(),
                    ]);

                    // Send Mail to Admin
                    Mail::to('mjrcoder7@gmail.com')->send(new LeaveMailToAdmin($insert));

                    if($insert){
                        Session::flash('success','Submited Your Leave Form!');
                        return redirect()->route('dashboard.leave.view',$insert->slug); 
                    }
                }
                Session::flash('error','Date Is not Correct!');
                return redirect()->route('dashboard.leave.add'); 
        }

        Session::flash('error','Already You have Applied');
        return redirect()->route('dashboard.dashboard');
    }

    public function view($slug){
        $user = User::where('slug',Auth::user()->slug)->first();
        $view = Leave::with('admin')->where('user_id',$user->id)->first();
        return view('admin.leave.view',compact('view'));
    } 
}
