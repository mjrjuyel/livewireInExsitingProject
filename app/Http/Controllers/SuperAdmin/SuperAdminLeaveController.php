<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveResponseByAdmin;
use Illuminate\Http\Request;
use App\Models\Leave;
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

    // view per role
    public function view($slug){
        $view = Leave::with('employe')->where('slug',$slug)->first();
        $leave_type = LeaveType::all();
        $defaultValue = EmployeLeaveSetting::where('id',1)->first();
        // return $view;
        return view('superadmin.leave.view',compact(['view','leave_type','defaultValue']));
    }

    public function update(Request $request){

        $id = $request['id'];
        $slug = $request['slug'];

        // dynamic 
        $default = EmployeLeaveSetting::where('id',1)->first();

        // check year whole year
        $startDate = Carbon::parse($request->start);
        // check month
        $checkPreviousMonth = Leave::with('employe')->where('status',2)->where('unpaid_request',0)->whereMonth('start_date',$startDate->month)->whereYear('start_date',$startDate->year)->latest('id')->first();
        $checkPreviousYear = Leave::with('employe')->where('status',2)->where('unpaid_request',0)->whereYear('start_date',$startDate->year)->latest('id')->first();
        // 
        $previousUnpaidYear = Leave::with('employe')->where('status',2)->where('unpaid_request',1)->whereYear('start_date',$startDate->year)->latest('id')->first();

        $currentRequest = Leave::where('slug',$slug)->first();

        // $reduce = $default->month_limit - $currentRequest->total_day;

        return $checkPreviousMonth;

        if($request->status == 2){
            // request Approved then chcek all the logic

            // If the leave request is not unpaid
            if($currentRequest->unpaid_request != 1 ){

                // if has taken  previous leave 
                if($checkPreviousMonth != null && $checkPreviousMonth != ''){
                // if previous month have taken leave and still have remain some day to take leave

                    // return $request->all();
                    $update = Leave::where('slug',$slug)->update([
                        'status'=>$request['status'],
                        'total_day'=>$currentRequest->total_day,
                        'paid_remaining_month'=>$checkPreviousMonth->paid_remaining_month - $currentRequest->total_day,
                        'paid_remaining_year'=>$checkPreviousYear->paid_remaining_year - $currentRequest->total_day,
                        'comments'=>$request['comment'],
                        'editor'=>Auth::user()->id,
                        'updated_at'=>Carbon::now(),
                    ]);

                }else{
                    // if the year doesn't take  zero leave
                    if($checkPreviousYear != null && $checkPreviousYear != ''){

                        // return "remain year leave"; 
                        $update = Leave::where('slug',$slug)->update([
                            'status'=>$request['status'],
                            'total_day'=>$currentRequest->total_day,
                            'paid_remaining_month'=>$default->month_limit - $currentRequest->total_day,
                            'paid_remaining_year'=>$checkPreviousYear->paid_remaining_year - $currentRequest->total_day,
                            'comments'=>$request['comment'],
                            'editor'=>Auth::user()->id,
                            'updated_at'=>Carbon::now(),
                        ]);

                        if($update){
                            Session::flash('success','Request Approved');
                            return redirect()->route('superadmin.leave.view',$slug);
                        }
                    }
                    else{
                        // return "both hav default value"; 
                        $update = Leave::where('slug',$slug)->update([
                            'status'=>$request['status'],
                            'total_day'=>$currentRequest->total_day,
                            'paid_remaining_month'=>$default->month_limit - $currentRequest->total_day,
                            'paid_remaining_year'=>$default->year_limit - $currentRequest->total_day,
                            'comments'=>$request['comment'],
                            'editor'=>Auth::user()->id,
                            'updated_at'=>Carbon::now(),
                        ]);

                        if($update){
                            Session::flash('success','Request Approved');
                            return redirect()->route('superadmin.leave.view',$slug);
                        }
                    }

                }
            }
            else{
                // unpaid rerquest update.
                if($previousUnpaidYear != null && $previousUnpaidYear != ''){
                    $update = Leave::where('slug',$slug)->update([
                        'status'=>$request['status'],
                        'total_day'=>$currentRequest->total_day,
                        'total_unpaid'=>$previousUnpaidYear->total_unpaid + $currentRequest->total_day,
                        'comments'=>$request['comment'],
                        'editor'=>Auth::user()->id,
                        'updated_at'=>Carbon::now(),
                    ]);
    
                    if($update){
                        Session::flash('success','Non Paid Leave Request Approved');
                        return redirect()->back();
                    }
                }
                else{
                    $update = Leave::where('slug',$slug)->update([
                        'status'=>$request['status'],
                        'total_day'=>$currentRequest->total_day,
                        'total_unpaid'=> 0 + $currentRequest->total_day,
                        'comments'=>$request['comment'],
                        'editor'=>Auth::user()->id,
                        'updated_at'=>Carbon::now(),
                    ]);
    
                    if($update){
                        Session::flash('success','Non Paid Leave Request Approved');
                        return redirect()->back();
                    }
                }
            }


        }


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
