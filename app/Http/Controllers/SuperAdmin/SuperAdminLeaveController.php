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
    public function add(){
        $employees = Employee::get(['id','emp_name']);
        $leaveType = LeaveType::get(['id','type_title']);
        // return $leaveType;
        return view('superadmin.leave.add',compact(['employees','leaveType']));
    }
    public function insert(Request $request){
        // validation

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
                        $overlappingLeaves = Leave::where('emp_id', $request->employe)
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

                                    $insert = Leave::create([
                                        'leave_type_id'=>$request['leave_type'],
                                        'other_type'=>$request['leave_type'] == 0 ? $request->others : null ,
                                        'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                        'end_date'=>$leavePermonth['end_date'],
                                        'reason'=>$request['reason'],
                                        'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                        // 'total_leave_this_month'=>($previousLeave && $previousLeave->total_leave_this_month !== null)? $previousLeave->total_leave_this_month + $paidLeaves + $unPaidLeaves : $paidLeaves + $unPaidLeaves,
                                        'total_paid'=>$paidLeaves,
                                        'total_unpaid'=>$unPaidLeaves > 0 ? $unPaidLeaves : null,
                                        'unpaid_request'=>$unPaidLeaves > 0 ? 1 : 0,
                                        'emp_id'=>$request->employe,
                                        'status'=>2,
                                        'add_from'=>'Admin',
                                        'slug'=>'leav-'.uniqId(),
                                        'created_at'=>Carbon::parse($leavePermonth['start_date']),
                                    ]);

                                    if ($insert) {
                                        if ($unPaidLeaves > 0) {
                                            Session::flash('success', 'Monthly leave limit reached! Extra days counted as unpaid.');
                                        } else {
                                            Session::flash('success', 'Application Sent to SuperAdmin');
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
        $employees = Employee::get(['id','emp_name']);
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
                            $overlappingLeaves = Leave::where('id', '!=', $id)
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

                                    $insert = Leave::where('id',$id)->update([
                                        'leave_type_id'=>$request['leave_type'],
                                        'other_type'=>$request['leave_type'] == 0 ? $request->others : null,
                                        'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                        'end_date'=>$leavePermonth['end_date'],
                                        'reason'=>$request['reason'],
                                        'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                        // 'total_leave_this_month'=>($previousLeave && $previousLeave->total_leave_this_month !== null)? $previousLeave->total_leave_this_month + $paidLeaves + $unPaidLeaves : $paidLeaves + $unPaidLeaves,
                                        'total_paid'=>$paidLeaves,
                                        'total_unpaid'=>$unPaidLeaves > 0 ? $unPaidLeaves : null,
                                        'unpaid_request'=>$unPaidLeaves > 0 ? 1 : 0,
                                        'emp_id'=>$request->employe,
                                        'status'=>2,
                                        'add_from'=>'Admin',
                                        'slug'=>'leav-'.uniqId(),
                                        'updated_at'=>Carbon::parse($leavePermonth['start_date']),
                                    ]);

                                    // $adminEmail = AdminEmail::first();

                                    // if($adminEmail->email_leave == 1){
                                        
                                    //     $getEmail = AdminEmail::where('id',1)->first();
                                    //     $explode = explode(',',$getEmail->email);
                                    //     // try {
                                    //     foreach($explode as $email){
                                    //         Mail::to($email)->send(new LeaveMailToAdmin($insert));
                                    //     }
                                    // }
                                    // notification
                                    // auth()->user()->notify(new LeaveToAdminNotification($insert));

                                    if ($insert) {
                                        if ($unPaidLeaves > 0) {
                                            Session::flash('success', 'Leave Information update and Monthly leave limit reached! Extra days counted as unpaid.');
                                        } else {
                                            Session::flash('success', 'Leave Information Update By Admin Dashboard User');
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
        $alldata = Leave::with(['admin','leavetype'])->where('status','!=',0)->orderBy('created_at','DESC')->get();
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
                    'updated_at'=>Carbon::now('UTC'),
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
                    'updated_at'=>Carbon::now('UTC'),
                ]);

                if($update){
                    Session::flash('success','Request Leave Cancle!');
                }
            }

            $alldata = Leave::where('id',$id)->first();
            
            Mail::to($employe->email)->send(new LeaveResponseByAdmin($alldata));

            $employe->notify(new LeaveToEmployeNotification($alldata));

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
