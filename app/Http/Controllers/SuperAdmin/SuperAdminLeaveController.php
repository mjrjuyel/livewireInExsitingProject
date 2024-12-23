<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveResponseByAdmin;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\EmployeLeaveSetting;
use Carbon\Carbon;
use Session;
use Auth;

class SuperAdminLeaveController extends Controller
{
    //  All Role 
    public function index(){
        $alldata = Leave::with(['admin','leavetype'])->where('status','!=',0)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.index',compact('alldata'));
    }

    public function pending(){
        $alldata = Leave::with(['admin','leavetype'])->where('status',1)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.pending',compact('alldata'));
    }
    public function approved(){
        $alldata = Leave::with(['admin','leavetype'])->where('status',2)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.approved',compact('alldata'));
    }

    public function cancled(){
        $alldata = Leave::with(['admin','leavetype'])->where('status',3)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.cancled',compact('alldata'));
    }

    // view per role
    public function view($slug){
        $view = Leave::with(['employe'=>function($query){
            $query->select('id','emp_name');
        }])->where('slug',$slug)->first();
        $leave_type = LeaveType::all();
        $defaultValue = EmployeLeaveSetting::where('id',1)->first();
        // return $view;
        return view('superadmin.leave.view',compact(['view','leave_type','defaultValue']));
    }

    public function update(Request $request){

        $id = $request['id'];
        $slug = $request['slug'];

        $default = EmployeLeaveSetting::where('id',1)->first();

        $email = Leave::find($id);
        // dynamic 
        $employe = Employee::where('id',$email->emp_id)->first();

            $update= Leave::where('slug',$slug)->update([
                'status'=>$request['status'],
                'comments'=>$request['comment'],
                'status'=>4,
                'editor'=>Auth::user()->id,
                'updated_at'=>Carbon::now(),
            ]);

            if($request->status == 2){
                $update = Leave::where('slug',$slug)->update([
                    'status'=>$request['status'],
                    'comments'=>$request['comment'],
                    'editor'=>Auth::user()->id,
                    'updated_at'=>Carbon::now(),
                ]);

                if($update){
                    Session::flash('success','Request Leave Approved');
                }

            }

            if($request->status == 3){
                $update = Leave::where('slug',$slug)->update([
                    'status'=>$request['status'],
                    'comments'=>$request['comment'],
                    'editor'=>Auth::user()->id,
                    'updated_at'=>Carbon::now(),
                ]);
               
                if($update){
                    Session::flash('success','Request Leave Cancle!');
                }
            }
            $alldata = Leave::where('id',$id)->first();
            // LeaveResponseByAdmin
            Mail::to($employe->email)->send(new LeaveResponseByAdmin($alldata));

            Session::flash('success','Updated Successfully');
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
