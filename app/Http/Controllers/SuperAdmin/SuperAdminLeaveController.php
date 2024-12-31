<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Mail\LeaveResponseByAdmin;
use App\Notifications\LeaveToEmployeNotification;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\EmployeLeaveSetting;
use Carbon\Carbon;
use Session;
use Auth;
use DB;

class SuperAdminLeaveController extends Controller
{
    //  All Role 
    public function index(){
        $alldata = Leave::with(['admin','leavetype'])->where('status','!=',0)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.index',compact('alldata'));
    }
    //index by month
    public function indexMonth($slug){
        $parseDate = Carbon::parse($slug);
        // return $parseDate;
        $alldata = Leave::with(['admin','leavetype'])->where('status','!=',0)->whereMonth('start_date',$parseDate->month)->whereYear('start_date',$parseDate->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.indexMonth',compact(['alldata','parseDate']));
    }

    public function indexYear($slug){
        $parseDate = Carbon::parse($slug);
        // return $parseDate;
        $alldata = Leave::with(['admin','leavetype'])->where('status','!=',0)->whereYear('start_date',$parseDate->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.indexYear',compact(['alldata','parseDate']));
    }

    public function pending(){
        $alldata = Leave::with(['admin','leavetype'])->where('status',1)->whereYear('start_date',now()->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.pending',compact('alldata'));
    }

    public function approved(){
        $alldata = Leave::with(['admin','leavetype'])->where('status',2)->whereYear('start_date',now()->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.approved',compact('alldata'));
    }

    public function cancled(){
        $alldata = Leave::with(['admin','leavetype'])->where('status',3)->whereYear('start_date',now()->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.cancled',compact('alldata'));
    }

    // view per role
    public function view($slug){
        $getId = Crypt::decrypt($slug);
        $view = Leave::with(['employe'=>function($query){
            $query->select('id','emp_name');
        }])->where('id',$getId)->first();
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
            Mail::to('mjrjuyel8@gmail.com')->send(new LeaveResponseByAdmin($alldata));

            $employe->notify(new LeaveToEmployeNotification($alldata));

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

    public function removeNotification($id){
        // return $id;
        $data = DB::table('notifications')->where('id',$id)->delete();
        if($data){
            return redirect()->back();
        }
    }
}
