<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Mail\LeaveResponseByAdmin;
use App\Notifications\LeaveToEmployeNotification;
use App\Mail\LeaveMailToAdmin;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\EmployeLeaveSetting;
use App\Models\AdminEmail;
use Carbon\Carbon;
use Session;
use Auth;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;

class SuperAdminLeaveController extends Controller
{

    public function __construct(){
        $this->middleware('permission:Leave Application List')->only('index');
        $this->middleware('permission:Add Manual Leave')->only('add','insert');
        $this->middleware('permission:Edit Manual Leave')->only('edit','updateleave');
        $this->middleware('permission:View Leave')->only('view','update');
        $this->middleware('permission:Delete Leave')->only('delete');
    }

    public function add(){
        $employees = User::get(['id','name']);
        $leaveType = LeaveType::get(['id','type_title']);
        // return $leaveType;
        return view('superadmin.leave.add',compact(['employees','leaveType']));
    }
    public function insert(Request $request){

                // return $request->all();
                    $request->validate([
                        'employe'=>'required',
                        'leave_type'=>'required',
                        'start'=>'required',
                        'reason'=>'required',
                        'others'=>'max:48',
                        'end'=>'required',
                    ]);

                    $definedLeave = EmployeLeaveSetting::where('id',1)->first();
                    $lastLeave = Leave::latest('id')->where('emp_id',$request->employe)->first();

                    $start_time = strtotime($request['start']);
                    $end_time = strtotime($request['end']);
                 

                // 2 dates are valid or not!
                if($start_time <= $end_time ){

                    // **NEW CONDITION: Check for overlapping leaves**
                        $overlappingLeaves = Leave::where('emp_id', $request->employe)->where('status',2)
                            ->where(function ($query) use ($request) {
                                $query->whereBetween('start_date', [$request['start'], $request['end']])
                                    ->orWhereBetween('end_date', [$request['start'], $request['end']])
                                    ->orWhere(function ($query) use ($request) {
                                        $query->where('start_date', '<=', $request['start'])
                                                ->where('end_date', '>=', $request['end']);
                                    });
                            })
                            ->exists();

                        if ($overlappingLeaves) {
                            Session::flash('error', 'Your leave request overlaps with a previously submitted leave.');
                            return redirect()->back();
                        }
                    
                    // Check Date And Count Total Day between 2 dates

                    function countDaysExcludingDynamicAndWeeklyOffs( $startDate,$endDate, $weeklyOffs = [],$specialOffDates = [],) {
                        
                        $start = new DateTime($startDate);
                        $end = new DateTime($endDate);

                        $end->modify('+1 day');
                        // Create a DatePeriod with a 1-day interval
                        $interval = new DateInterval('P1D');
                        $period = new DatePeriod($start, $interval, $end);
                        $totalDays = 0;
                        // Iterate over each day in the period
                        foreach ($period as $date) {
                            // Exclude if the day is a weekly off OR a special off date
                            if (
                                !in_array($date->format('N'), $weeklyOffs) &&
                                !in_array($date->format('Y-m-d'), $specialOffDates)
                            ) {
                                $totalDays++;
                            }
                        }
                        return $totalDays;
                    }

                    // check Leaves
                    function calculateLeaves($startDate, $endDate, $weeklyOffs = [], $specialOffDates = []) {
                        $start = new DateTime($startDate);
                        $end = new DateTime($endDate);

                        $leaveSummary = [];
                        $currentDate = $start;

                        // Loop through each month in the range
                        while ($currentDate <= $end) {
                            
                            $currentMonth=$currentDate->format('Y-m');
                            $monthStart = new DateTime($currentDate->format('Y-m-01'));
                            $monthEnd = new DateTime($currentDate->format('Y-m-t'));
                            
                            // Adjust the range for the first and last months
                            $monthStart = max($currentDate, $monthStart);
                            $monthEnd = min($end, $monthEnd);
                            
                            // Count valid leave days in the current month
                            $daysInMonth = countDaysExcludingDynamicAndWeeklyOffs(
                            $monthStart->format('Y-m-d'),
                            $monthEnd->format('Y-m-d'),
                            $weeklyOffs,
                            $specialOffDates
                            );

                            // $monthEnd->modify('+1 days');
                            $leaveSummary[] = [
                            'start_date' => $currentDate->format('Y-m-d'),
                            'end_date'=> $monthEnd,
                            'totalDays' => $daysInMonth,
                            // 'paidLeaves' => $paidLeaves,
                            // 'unpaidLeaves' => $unpaidLeaves,
                            ];

                            // Move to the next month
                            $currentDate->modify('first day of next month');
                        }

                            return $leaveSummary;
                    }

                    // Data Pass in calculates Leaves
                    $startDate = $request['start'];
                    $endDate = $request['end'];

                    // Define weekly offs  5 = Friday)

                    $weeklyOffs = explode(',',$definedLeave->weekoffday);
                    // return $weeklyOffs;

                    // speacial off Day with Govt Day
                    $specialOffDates = explode(',',$definedLeave->specialoffday);

                    // sort by ascending
                    usort($specialOffDates,function($a,$b){
                        return strtotime($a) - strtotime($b);
                    });

                    $leaveSummary = calculateLeaves($startDate, $endDate, $weeklyOffs, $specialOffDates);

                    foreach($leaveSummary as $leavePermonth){

                                $start_date = Carbon::parse($leavePermonth['start_date']); // Parsing day in Month, year;
                                $end_date = Carbon::parse($leavePermonth['end_date']); // Parsing day in Month, year;

                                // check total Paid of in a month
                                $checkMonth = Leave::where('emp_id',$request->employe)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('total_paid');
                                
                                $previousLeave = Leave::where('emp_id',$request->employe)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->latest('id')->first();
                                // return $previousLeave !== null ? "this have value " : "Its A  null property";

                                // check total paid off in an annual year
                                $checkYear = Leave::where('emp_id',$request->employe)->where('status',2)->whereYear('start_date',$start_date->year)->sum('total_paid');
                                
                                $remainingMonthlyPaidLeave = max(0, $definedLeave->month_limit - $checkMonth);

                                // return $remainingMonthlyPaidLeave;
                                $paidLeaves = min($remainingMonthlyPaidLeave,$leavePermonth['totalDays']);
                                // return $paidLeaves;
                                $unPaidLeaves = $leavePermonth['totalDays'] - $paidLeaves;

                                    // if unpaid request
                                    if($request->unpaid){
                                            $insert = Leave::create([
                                                'leave_type_id'=>$request['leave_type'],
                                                'other_type'=>$request['leave_type'] == 0 ? $request->others : null ,
                                                'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                                'end_date'=>$leavePermonth['end_date'],
                                                'reason'=>$request['reason'],
                                                'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                                'total_paid'=>0,
                                                'total_unpaid'=> $paidLeaves + $unPaidLeaves,
                                                'unpaid_request'=>$request->unpaid,
                                                'emp_id'=>$request->employe,
                                                'status'=>2,
                                                'add_from'=>Auth::user()->name,
                                                'created_at'=>Carbon::parse($leavePermonth['start_date']) > Carbon::now() ? Carbon::now('UTC') : Carbon::parse($leavePermonth['start_date']),
                                            ]);

                                            if ($insert) {
                                                    Session::flash('success', 'You have successfully created an employee Un-Paid leave information');
                                                    return redirect()->back();
                                                }
                                     }else{
                                        $insert = Leave::create([
                                            'leave_type_id'=>$request['leave_type'],
                                            'other_type'=>$request['leave_type'] == 0 ? $request->others : null ,
                                            'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                            'end_date'=>$leavePermonth['end_date'],
                                            'reason'=>$request['reason'],
                                            'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                            'total_paid'=>$paidLeaves,
                                            'total_unpaid'=>$unPaidLeaves > 0 ? $unPaidLeaves : null,
                                            'unpaid_request'=>$request->unpaid,
                                            'emp_id'=>$request->employe,
                                            'status'=>2,
                                            'add_from'=>Auth::user()->name,
                                            'created_at'=>Carbon::parse($leavePermonth['start_date']) > Carbon::now() ? Carbon::now('UTC') : Carbon::parse($leavePermonth['start_date']),
                                        ]);

                                        if ($insert) {
                                            if ($unPaidLeaves > 0) {
                                                Session::flash('success', 'You have successfully created an employee  and un-paid leave information.');
                                            } else {
                                                Session::flash('success', 'You have successfully created an employee paid leave information');
                                            }

                                        }
                                     }
                            
                    } 
                    return redirect()->back();
                }
            Session::flash('error','Date Is not Correct!');
            return redirect()->back();
                
    }


    public function edit($id){
        $ID = Crypt::decrypt($id);
        $edit= Leave::where('id',$ID)->first();
        $employees = User::get(['id','emp_name']);
        $leaveType = LeaveType::get(['id','type_title']);
        // return $edit;
        return view('superadmin.leave.edit',compact(['employees','edit','leaveType']));
    }

    public function updateleave(Request $request){
        // validation

            $id = $request->id;
                // return $request->all();
                    $request->validate([
                        'employe'=>'required',
                        'leave_type'=>'required',
                        'start'=>'required',
                        'reason'=>'required',
                        'others'=>'max:30',
                        'end'=>'required',
                    ]);

                    $definedLeave = EmployeLeaveSetting::where('id',1)->first();
                    $lastLeave = Leave::latest('id')->where('emp_id',$request->employe)->first();

                        // Convert English date into Unix time stamp 
                    $start_time = strtotime($request['start']);
                    $end_time = strtotime($request['end']);
                    // $currTime = strtotime(now());

                    // $before5Days = strtotime('-5 days', $currTime);

                // 2 dates are valid or not!
                if($start_time <= $end_time ){

                    // **NEW CONDITION: Check for overlapping leaves**
                            $overlappingLeaves = Leave::where('id', '!=', $id)->where('status',2)
                            ->where('emp_id', $request->employe)
                            ->where(function ($query) use ($request) {
                                $query->where(function ($q) use ($request) {
                                    $q->whereBetween('start_date', [$request['start'], $request['end']])
                                      ->orWhereBetween('end_date', [$request['start'], $request['end']]);
                                })
                                ->orWhere(function ($q) use ($request) {
                                    $q->where('start_date', '<=', $request['start'])
                                      ->where('end_date', '>=', $request['end']);
                                });
                            })
                            ->exists();

                            // dd($id, $request->employe, $request->start, $request->end);
                        if ($overlappingLeaves) {
                            Session::flash('error', 'Your leave request overlaps with a previously submitted leave.');
                            return redirect()->back();
                        }
                    
                    // Check Date And Count Total Day between 2 dates

                    function countDaysExcludingDynamicAndWeeklyOffs( $startDate,$endDate, $weeklyOffs = [],$specialOffDates = [],) {
                        // Create DateTime objects for the start and end dates
                        $start = new DateTime($startDate);
                        $end = new DateTime($endDate);
                        // Include the end date in the calculation
                        $end->modify('+1 day');
                        // Create a DatePeriod with a 1-day interval
                        $interval = new DateInterval('P1D');
                        $period = new DatePeriod($start, $interval, $end);
                        $totalDays = 0;
                        // Iterate over each day in the period
                        foreach ($period as $date) {
                            // Exclude if the day is a weekly off OR a special off date
                            if (
                                !in_array($date->format('N'), $weeklyOffs) &&
                                !in_array($date->format('Y-m-d'), $specialOffDates)
                            ) {
                                $totalDays++;
                            }
                        }
                        return $totalDays;
                    }

                    // check Leaves
                    function calculateLeaves($startDate, $endDate, $weeklyOffs = [], $specialOffDates = []) {
                        $start = new DateTime($startDate);
                        $end = new DateTime($endDate);

                        $leaveSummary = [];
                        $currentDate = $start;

                        // Loop through each month in the range
                        while ($currentDate <= $end) {
                            
                            $currentMonth=$currentDate->format('Y-m');
                            $monthStart = new DateTime($currentDate->format('Y-m-01'));
                            $monthEnd = new DateTime($currentDate->format('Y-m-t'));
                            
                            // Adjust the range for the first and last months
                            $monthStart = max($currentDate, $monthStart);
                            $monthEnd = min($end, $monthEnd);
                            
                            // Count valid leave days in the current month
                            $daysInMonth = countDaysExcludingDynamicAndWeeklyOffs(
                            $monthStart->format('Y-m-d'),
                            $monthEnd->format('Y-m-d'),
                            $weeklyOffs,
                            $specialOffDates
                            );

                            // $monthEnd->modify('+1 days');
                            $leaveSummary[] = [
                            'start_date' => $currentDate->format('Y-m-d'),
                            'end_date'=> $monthEnd,
                            'totalDays' => $daysInMonth,
                            // 'paidLeaves' => $paidLeaves,
                            // 'unpaidLeaves' => $unpaidLeaves,
                            ];

                            // Move to the next month
                            $currentDate->modify('first day of next month');
                        }

                            return $leaveSummary;
                    }

                    // Data Pass in calculates Leaves
                    $startDate = $request['start'];
                    $endDate = $request['end'];

                    // Define weekly offs  5 = Friday)

                    $weeklyOffs = explode(',',$definedLeave->weekoffday);
                    // return $weeklyOffs;

                    // speacial off Day with Govt Day
                    $specialOffDates = explode(',',$definedLeave->specialoffday);

                    // sort by ascending
                    usort($specialOffDates,function($a,$b){
                        return strtotime($a) - strtotime($b);
                    });

                    $leaveSummary = calculateLeaves($startDate, $endDate, $weeklyOffs, $specialOffDates);

                    foreach($leaveSummary as $leavePermonth){

                            $start_date = Carbon::parse($leavePermonth['start_date']); // Parsing day in Month, year;
                            $end_date = Carbon::parse($leavePermonth['end_date']); // Parsing day in Month, year;

                            // check total Paid of in a month
                            $checkMonth = Leave::where('id','!=',$id)->where('emp_id',$request->employe)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('total_paid');
                            
                            $previousLeave = Leave::where('id','!=',$id)->where('emp_id',$request->employe)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->latest('id')->first();
                            // return $previousLeave !== null ? "this have value " : "Its A  null property";

                            // check total paid off in an annual year
                            $checkYear = Leave::where('id','!=',$id)->where('emp_id',$request->employe)->where('status',2)->whereYear('start_date',$start_date->year)->sum('total_paid');
                            
                            $remainingMonthlyPaidLeave = max(0, $definedLeave->month_limit - $checkMonth);

                            // return $remainingMonthlyPaidLeave;
                            $paidLeaves = min($remainingMonthlyPaidLeave,$leavePermonth['totalDays']);
                            // return $paidLeaves;
                            $unPaidLeaves = $leavePermonth['totalDays'] - $paidLeaves;

                            if($request->unpaid){
                                $update = Leave::where('id',$id)->update([
                                    'leave_type_id'=>$request['leave_type'],
                                    'other_type'=>$request['leave_type'] == 0 ? $request->others : null ,
                                    'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                    'end_date'=>$leavePermonth['end_date'],
                                    'reason'=>$request['reason'],
                                    'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                    'total_paid'=>0,
                                    'total_unpaid'=> $paidLeaves + $unPaidLeaves,
                                    'unpaid_request'=>$request->unpaid,
                                    'emp_id'=>$request->employe,
                                    'status'=>2,
                                    'add_from'=>Auth::user()->name,
                                    'updated_at'=>Carbon::parse($leavePermonth['start_date']) > Carbon::now() ? Carbon::now('UTC') : Carbon::parse($leavePermonth['start_date']),
                                ]);

                                if ($update) {
                                        Session::flash('success', 'You have successfully Updated an employee Un-Paid leave information');
                                        return redirect()->back();
                                    }
                         }else{
                            $update = Leave::where('id',$id)->update([
                                'leave_type_id'=>$request['leave_type'],
                                'other_type'=>$request['leave_type'] == 0 ? $request->others : null ,
                                'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                'end_date'=>$leavePermonth['end_date'],
                                'reason'=>$request['reason'],
                                'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                'total_paid'=>$paidLeaves,
                                'total_unpaid'=>$unPaidLeaves > 0 ? $unPaidLeaves : null,
                                'unpaid_request'=>$request->unpaid,
                                'emp_id'=>$request->employe,
                                'status'=>2,
                                'add_from'=>Auth::user()->name,
                                'updated_at'=>Carbon::parse($leavePermonth['start_date']) > Carbon::now() ? Carbon::now('UTC') : Carbon::parse($leavePermonth['start_date']),
                            ]);

                            if ($update) {
                                if ($unPaidLeaves > 0) {
                                    Session::flash('success', 'You have successfully Updated an employee Paid and un-paid leave information.');
                                } else {
                                    Session::flash('success', 'You have successfully Updated an employee paid leave information');
                                }

                            }
                         }
                            
                    }
                    return redirect()->back();
                }
            Session::flash('error','Date Is not Correct!');
            return redirect()->back();
                
    }

    //  All Leave
    public function index(){
        $alldata = Leave::with(['employe:id,name','admin','leavetype:id,type_title'])->where('status','!=',0)->orderBy('created_at','DESC')->get();
        // return $alldata;
        return view('superadmin.leave.index',compact('alldata'));
    }
    //index by month
    public function indexMonth($slug){
        $parseDate = Carbon::parse($slug);
        // return $parseDate;
        $alldata = Leave::with(['employe:id,name','admin','leavetype:id,type_title'])->where('status','!=',0)->whereMonth('start_date',$parseDate->month)->whereYear('start_date',$parseDate->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.indexMonth',compact(['alldata','parseDate']));
    }

    public function indexYear($slug){
        $parseDate = Carbon::parse($slug);
        // return $parseDate;
        $alldata = Leave::with(['employe:id,name','admin','leavetype:id,type_title'])->where('status','!=',0)->whereYear('start_date',$parseDate->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.indexYear',compact(['alldata','parseDate']));
    }

    public function pending(){
        $alldata = Leave::with(['employe:id,name','admin','leavetype:id,type_title'])->where('status',1)->whereYear('start_date',now()->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.pending',compact('alldata'));
    }

    public function approved(){
        $alldata = Leave::with(['employe:id,name','admin','leavetype:id,type_title'])->where('status',2)->whereYear('start_date',now()->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.approved',compact('alldata'));
    }

    public function cancled(){
        $alldata = Leave::with(['employe:id,name','admin','leavetype:id,type_title'])->where('status',3)->whereYear('start_date',now()->year)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.cancled',compact('alldata'));
    }

    // view per role
    public function view($slug){
        $getId = Crypt::decrypt($slug);
        $view = Leave::with(['employe:id,name','leavetype:id,type_title'])->where('id',$getId)->first();
        return view('superadmin.leave.view',compact(['view']));
    }

    public function update(Request $request){

        $id = $request['id'];
        $slug = $request['slug'];

        $default = EmployeLeaveSetting::where('id',1)->first();
        $specific_data = Leave::find($id);
        $employe = User::where('id',$specific_data->emp_id)->first();

            $update= Leave::where('id',$id)->update([
                'status'=>$request['status'],
                'comments'=>$request['comment'],
                'status'=>4,
                'editor'=>Auth::user()->id,
                'updated_at'=>Carbon::now(),
            ]);

            if($request->unpaidLeave){
                $update = Leave::where('id',$id)->update([
                    'total_unpaid'=>$request->unpaidDay,
                    'total_paid'=>$request->total_leave - $request->unpaidDay,
                ]);
            }

            if($request->status == 2){
                $update = Leave::where('id',$id)->update([
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
                $update = Leave::where('id',$id)->update([
                    'status'=>$request['status'],
                    'comments'=>$request['comment'],
                    'editor'=>Auth::user()->id,
                    'updated_at'=>Carbon::now('UTC'),
                ]);

                if($update){
                    Session::flash('success','Request Leave Cancle!');
                }
            }


            $alldata = Leave::where('id',$id)->first();
            
            Mail::to($employe->email)->send(new LeaveResponseByAdmin($alldata));
            // return $alldata;
            // $employe->notify(new LeaveToEmployeNotification($alldata));

            Session::flash('success','Updated Successfully');
            return redirect()->back();
        
    }

     // soft Delete
     public function softDelete(Request $request){
        $slug = $request['id'];
        
        $softdelete = Leave::where('status','!=',0)->where('id',$slug)->update([
            'status'=>0,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);
        if($softdelete){
            Session::flash('error','Moved Into Trash !');
            return redirect()->back();
        }
    }

    public function restore(Request $request){

        $id = $request['id'];

        $store = Leave::where('id',$id)->update([
            'status'=>1,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($store){
            Session::flash('success','Restore Employee Leave Data');
            return redirect()->back();
        }
    }
    // Delete
    public function delete(Request $request){
        $delete = Leave::findOrFail($request->id);
        $delete->delete();
        if($delete){
        Session::flash('success','Request Employee Leave Data Delete');
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
