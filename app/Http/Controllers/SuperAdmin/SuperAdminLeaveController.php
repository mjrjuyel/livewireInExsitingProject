<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveResponseByAdmin;
use Illuminate\Http\Request;
use App\Models\Leave;
use Carbon\Carbon;
use Session;
use Auth;

class SuperAdminLeaveController extends Controller
{
    //  All Role 
    public function index(){
        $alldata = Leave::with('admin')->where('status','!=',0)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.index',compact('alldata'));
    }

    // view per role
    public function view($slug){
        $view = Leave::with('employe')->where('slug',$slug)->first();
        // return $view;
        return view('superadmin.leave.view',compact('view'));
    }

    public function update(Request $request){
        $id = $request['id'];
        $slug = $request['slug'];

        $leave = Leave::with('employe')->where('slug',$slug)->first();
        
        $update = Leave::where('id',$id)->update([
            'status'=>$request['status'],
            'updated_at'=>Carbon::now(),
        ]);

        // if($request->status == 2){
        //     return  "status 2";
        // }
        
        // If Date is Modified
        if($request->end){
            $start =strtotime($leave->start_date);
            $end_date = strtotime($request->end);

            $dayInsec = $end_date - $start;
            $total_days = $dayInsec / 86400;

            // return $total_days;
            
            Leave::where('id',$id)->where('status',2)->update([
                'end_date'=>$end_date,
                'total_day'=>$total_days,
                'paid_remainig_month'=>$leave->paid_remainig_month + $total_days,
                'paid_remainig_year'=>$leave->paid_remainig_year + $total_days,
            ]);
        
        }else{
            // update remainig leave
                if($request->status == 2){
                     Leave::where('id',$leave->id)->update([
                        'paid_remainig_month'=>$leave->paid_remainig_month + $leave->total_day,
                        'paid_remaining_year'=>$leave->paid_remaining_year + $leave->total_day,
                    ]);
                }
            }
        if($update){
            $email = Leave::where('slug',$slug)->first();
            Mail::to($email->employe->email)->send(new LeaveResponseByAdmin($email));
        }
        Session::flash('success','Update Leave Form!');
        return redirect()->back();
    }

    public function delete($slug){
        $delete = Leave::where('slug',$slug)->first();
        $delete->delete();
        if($delete){
            $leave = Leave::all();
        // Update the auto-incrementing column values
            foreach ($leave as $index => $row) {
                $row->id = $index + 1;
                $row->save();
            }
        Session::flash('success','Leave Application Delete');
        return redirect()->back();
        }
    }
}
