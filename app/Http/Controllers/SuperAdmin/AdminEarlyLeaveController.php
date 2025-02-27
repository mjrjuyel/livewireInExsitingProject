<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EarlyLeaveResponseMail;
use App\Models\EarlyLeave;
use App\Models\Employee;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;
use Session;

class AdminEarlyLeaveController extends Controller
{
    public function __construct(){
        $this->middleware('permission:All Early Leave')->only('index');
        $this->middleware('permission:Add Early Leave')->only('add','insert');
        $this->middleware('permission:Edit Early Leave')->only('edit');
        $this->middleware('permission:View Early Leave')->only('view','update');
        $this->middleware('permission:Delete Early Leave')->only('delete','softDelete');
    }

    public function index(){
        $leaves = EarlyLeave::where('status','!=',0)->latest('id')->get();
        // return $leaves;
        return view('superadmin.earlyleave.index',compact('leaves'));
    }

    public function view($id){
        $Id = Crypt::decrypt($id);
        $view = EarlyLeave::findOrFail($Id);
        return view('superadmin.earlyleave.view',compact('view'));
    }

    // approve appliacation
    public function update(Request $request){

        $id = $request['id'];
        // $slug = $request['slug'];

        // $default = EmployeLeaveSetting::where('id',1)->first();

        $email = EarlyLeave::find($id);
        // dynamic 
        $employe = Employee::where('id',$email->emp_id)->first();

            $update= EarlyLeave::where('id',$id)->update([
                'status'=>$request['status'],
                'comments'=>$request['comment'],
                'status'=>4,
                'editor'=>Auth::user()->id,
                'updated_at'=>Carbon::now(),
            ]);

            // if($request->unpaidLeave){
            //     $update = EarlyLeave::where('id',$id)->update([
            //         'total_unpaid'=>$request->unpaidDay,
            //         'total_paid'=>$request->total_leave - $request->unpaidDay,
            //     ]);
            // }

            if($request->status == 2){
                $update = EarlyLeave::where('id',$id)->update([
                    'status'=>$request['status'],
                    'comments'=>$request['comment'],
                    'editor'=>Auth::user()->id,
                    'updated_at'=>Carbon::now('UTC'),
                ]);

                if($update){
                    Session::flash('success','Request Leave Approved');
                }
            }

            if($request->status == 3){
                $update = EarlyLeave::where('id',$id)->update([
                    'status'=>$request['status'],
                    'comments'=>$request['comment'],
                    'editor'=>Auth::user()->id,
                    'updated_at'=>Carbon::now('UTC'),
                ]);

                if($update){
                    Session::flash('success','Request Leave Cancle!');
                }
            }

            // $alldata = EarlyLeave::where('id',$id)->first();
            
            // Mail::to($employe->email)->send(new EarlyLeaveResponseMail($alldata));

            // $employe->notify(new LeaveToEmployeNotification($alldata));

            Session::flash('success','Updated Successfully');
            return redirect()->back();
        
    }

    // soft Delete
    public function softDelete(Request $request){
        $id = $request->id;
        
        $softdele = EarlyLeave::where('id',$id)->update([
            'status'=>0,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC')
        ]);

        if($softdele){
            Session::flash('success','One Early Leave Data Moved to Trash!');
            return redirect()->back();
        }
    }

}
