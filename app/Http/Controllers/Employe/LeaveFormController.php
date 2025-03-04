<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailToAdmin;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveToAdminNotification;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\EmployeLeaveSetting;
use App\Models\Employee;
use App\Models\AdminEmail;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;
use Exception;



class LeaveFormController extends Controller
{
    public function add(){
        $leaveType = LeaveType::latest('id')->get();
        return view('employe.leave.add',compact('leaveType'));
    }
    // add Leave
    public function insert(Request $request){
                // validation

                // return $request->all();
                    $request->validate([
                        'leave_type'=>'required',
                        'start'=>'required',
                        'others'=>'max:50',
                        'reason'=>'required',
                        'end'=>'required',
                    ]);

                    $definedLeave = EmployeLeaveSetting::where('id',1)->first();
                    $lastLeave = Leave::latest('id')->where('emp_id',Auth::guard('employee')->user()->id)->first();

                    if($lastLeave == Null || $lastLeave->status == 2 || $lastLeave->status == 3){

                          // Convert English date into Unix time stamp 
                    $start_time = strtotime($request['start']);
                    $end_time = strtotime($request['end']);
                    $currTime = strtotime(now());

                    $before5Days = strtotime('-5 days', $currTime);
                    // return "Now Date" .$currTime . "Before 5 days" . $before5Days;
                    // return $start_time . " > Start Time <br>" . "current time " .$curr;
                // 2 dates are valid or not!
                if($start_time <= $end_time && $start_time >= $before5Days){

                    // **NEW CONDITION: Check for overlapping leaves**
                        $overlappingLeaves = Leave::where('emp_id', Auth::guard('employee')->user()->id)->where('status',2)
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
                            return redirect()->route('dashboard.leave.add');
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
                            $checkMonth = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('total_paid');
                            
                            $previousLeave = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->latest('id')->first();
                            // return $previousLeave !== null ? "this have value " : "Its A  null property";

                            // check total paid off in an annual year
                            $checkYear = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereYear('start_date',$start_date->year)->sum('total_paid');
                            
                            $remainingMonthlyPaidLeave = max(0, $definedLeave->month_limit - $checkMonth);

                            // return $remainingMonthlyPaidLeave;
                            $paidLeaves = min($remainingMonthlyPaidLeave,$leavePermonth['totalDays']);
                            // return $paidLeaves;
                            $unPaidLeaves = $leavePermonth['totalDays'] - $paidLeaves;

                                    if($request->unpaid){
                                        $insert = Leave::create([
                                            'leave_type_id'=>$request['leave_type'],
                                            'other_type'=>$request['leave_type'] == 0 ? $request->others : null,
                                            'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                            'end_date'=>$leavePermonth['end_date'],
                                            'reason'=>$request['reason'],
                                            'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                            // 'total_leave_this_month'=>($previousLeave && $previousLeave->total_leave_this_month !== null)? $previousLeave->total_leave_this_month + $paidLeaves + $unPaidLeaves : $paidLeaves + $unPaidLeaves,
                                            'total_paid'=>0,
                                            'total_unpaid'=>$paidLeaves + $unPaidLeaves,
                                            'unpaid_request'=>$request->unpaid,
                                            'emp_id'=>Auth::guard('employee')->user()->id,
                                            'slug'=>'leav-'.uniqId(),
                                            'add_from'=>Auth::guard('employee')->user()->name,
                                            'created_at'=>Carbon::now('UTC'),
                                        ]);
    
                                        $adminEmail = AdminEmail::first();
    
                                        if($adminEmail->email_leave == 1){
                                            
                                            $getEmail = AdminEmail::where('id',1)->first();
                                            $explode = explode(',',$getEmail->email);
                                            // try {
                                            foreach($explode as $email){
                                                Mail::to($email)->send(new LeaveMailToAdmin($insert));
                                            }
                                        }
                                        // notification
                                        // auth()->user()->notify(new LeaveToAdminNotification($insert));
    
                                        if ($insert) {
                                            Session::flash('success', 'You Send an Un-Paid Leave Request to Admin'); 
                                        }
                                    }else{
                                        $insert = Leave::create([
                                            'leave_type_id'=>$request['leave_type'],
                                            'other_type'=>$request['leave_type'] == 0 ? $request->others : null,
                                            'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                            'end_date'=>$leavePermonth['end_date'],
                                            'reason'=>$request['reason'],
                                            'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                            // 'total_leave_this_month'=>($previousLeave && $previousLeave->total_leave_this_month !== null)? $previousLeave->total_leave_this_month + $paidLeaves + $unPaidLeaves : $paidLeaves + $unPaidLeaves,
                                            'total_paid'=>$paidLeaves,
                                            'total_unpaid'=>$unPaidLeaves > 0 ? $unPaidLeaves : null,
                                            'unpaid_request'=>$request->unpaid,
                                            'emp_id'=>Auth::guard('employee')->user()->id,
                                            'slug'=>'leav-'.uniqId(),
                                            'add_from'=>'Employee',
                                            'created_at'=>Carbon::now('UTC'),
                                        ]);
    
                                        $adminEmail = AdminEmail::first();
    
                                        if($adminEmail->email_leave == 1){
                                            
                                            $getEmail = AdminEmail::where('id',1)->first();
                                            $explode = explode(',',$getEmail->email);
                                            // try {
                                            foreach($explode as $email){
                                                Mail::to($email)->send(new LeaveMailToAdmin($insert));
                                            }
                                        }
                                        // notification
                                        // auth()->user()->notify(new LeaveToAdminNotification($insert));
    
                                        if ($insert) {
                                            if ($unPaidLeaves > 0) {
                                                Session::flash('success', 'Monthly leave limit reached! Extra days counted as unpaid.');
                                            } else {
                                                Session::flash('success', 'Leave Request Send to Admin');
                                            }
                                            
                                        }
                                    }
                             
                    }

                    return redirect()->route('dashboard.leave.history',Crypt::encrypt(Auth::guard('employee')->user()->id));
                }
            Session::flash('error','Date Is not Correct!');
            return redirect()->route('dashboard.leave.add');
        }
        Session::flash('error','Already Your last Leave Request Is Pending');
        return redirect()->route('dashboard.leave.add');
                  
    }

    // Edit leave

    public function edit($id){
        $ID = Crypt::decrypt($id);
        $edit= Leave::where('id',$ID)->first();
        $leaveType = LeaveType::all();
        // return $leaveType;
        return view('employe.leave.edit',compact(['edit','leaveType']));
    }
    public function update(Request $request){

                $id = $request->id;
                // return $request->all();
                    $request->validate([
                        'leave_type'=>'required',
                        'start'=>'required',
                        'others'=>'max:50',
                        'reason'=>'required',
                        'end'=>'required',
                    ]);

                    $definedLeave = EmployeLeaveSetting::where('id',1)->first();

                        // Convert English date into Unix time stamp 
                    $start_time = strtotime($request['start']);
                    $end_time = strtotime($request['end']);
                    $currTime = strtotime(now());

                    $before5Days = strtotime('-5 days', $currTime);
                    // return "Now Date" .$currTime . "Before 5 days" . $before5Days;
                    // return $start_time . " > Start Time <br>" . "current time " .$curr;
                // 2 dates are valid or not!
                if($start_time <= $end_time && $start_time >= $before5Days){
                    
                    // **NEW CONDITION: Check for overlapping leaves**
                        $overlappingLeaves = Leave::where('id','!=',$id)->where('emp_id', Auth::guard('employee')->user()->id)->where('status',2)
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
                    // return "juyel";
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
                            $checkMonth = Leave::where('id','!=',$id)->where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('total_paid');
                            
                            $previousLeave = Leave::where('id','!=',$id)->where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->latest('id')->first();
                            // return $previousLeave !== null ? "this have value " : "Its A  null property";

                            // check total paid off in an annual year
                            $checkYear = Leave::where('id','!=',$id)->where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereYear('start_date',$start_date->year)->sum('total_paid');
                            
                            $remainingMonthlyPaidLeave = max(0, $definedLeave->month_limit - $checkMonth);

                            // return $remainingMonthlyPaidLeave;
                            $paidLeaves = min($remainingMonthlyPaidLeave,$leavePermonth['totalDays']);
                            // return $paidLeaves;
                            $unPaidLeaves = $leavePermonth['totalDays'] - $paidLeaves;
                            
                                    if($request->unpaid){
                                        // return "unpaid";
                                        $update = Leave::where('id',$request->id)->update([
                                            'leave_type_id'=>$request['leave_type'],
                                            'other_type'=>$request['leave_type'] == 0 ? $request->others : null,
                                            'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                            'end_date'=>$leavePermonth['end_date'],
                                            'reason'=>$request['reason'],
                                            'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                            'total_paid'=>0,
                                            'total_unpaid'=>$paidLeaves + $unPaidLeaves,
                                            'unpaid_request'=>$request->unpaid,
                                            'emp_id'=>Auth::guard('employee')->user()->id,
                                            'slug'=>'leav-'.uniqId(),
                                            'status'=>1,
                                            'add_from'=>Auth::guard('employee')->user()->emp_name,
                                            'created_at'=>Carbon::now('UTC'),
                                        ]);
    
                                        $data = Leave::where('id',$id)->first();

                                        $adminEmail = AdminEmail::first();
    
                                        if($adminEmail->email_leave == 1){
                                            
                                            $getEmail = AdminEmail::where('id',1)->first();
                                            $explode = explode(',',$getEmail->email);
                                            // try {
                                            foreach($explode as $email){
                                                Mail::to($email)->send(new LeaveMailToAdmin($data));
                                            }
                                        }
                                        // notification
                                        // auth()->user()->notify(new LeaveToAdminNotification($insert));
    
                                        if ($update) {
                                            Session::flash('success', 'You Have Edited and send Un-Paid Leave Request To Admin'); 
                                        }
                                    }else{
                                        $update = Leave::where('id',$request->id)->update([
                                            'leave_type_id'=>$request['leave_type'],
                                            'other_type'=>$request['leave_type'] == 0 ? $request->others : null,
                                            'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                            'end_date'=>$leavePermonth['end_date'],
                                            'reason'=>$request['reason'],
                                            'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                            'total_paid'=>$paidLeaves,
                                            'total_unpaid'=>$unPaidLeaves > 0 ? $unPaidLeaves : null,
                                            'unpaid_request'=>$request->unpaid,
                                            'emp_id'=>Auth::guard('employee')->user()->id,
                                            'slug'=>'leav-'.uniqId(),
                                            'status'=>1,
                                            'add_from'=>Auth::guard('employee')->user()->emp_name,
                                            'created_at'=>Carbon::now('UTC'),
                                        ]);
    
                                        $data = Leave::where('id',$id)->first();
                                        
                                        $adminEmail = AdminEmail::first();
    
                                        if($adminEmail->email_leave == 1){
                                            
                                            $getEmail = AdminEmail::where('id',1)->first();
                                            $explode = explode(',',$getEmail->email);
                                            // try {
                                            foreach($explode as $email){
                                                Mail::to($email)->send(new LeaveMailToAdmin($data));
                                            }
                                        }
                                        // notification
                                        // auth()->user()->notify(new LeaveToAdminNotification($insert));
    
                                        if ($update) {
                                            if ($unPaidLeaves > 0) {
                                                Session::flash('success', 'You Have Edited and send Paid & Un-Paid Leave Request To Admin');
                                            } else {
                                                Session::flash('success', 'You Have Edited and send Paid Leave Request To Admin');
                                            }
                                            
                                        }
                                    }
                            
                    }

                    return redirect()->back();
                }
            Session::flash('error','Date Is not Correct!');
            return redirect()->back();
        }

    public function view($slug){
        $emp = Employee::where('emp_slug',Auth::guard('employee')->user()->emp_slug)->first();
        // dd($emp);
        $useId = Crypt::decrypt($slug);

        $view = Leave::with(['employe'=>function($query){
            $query->select('id','emp_name');
        },'leavetype'])->where('id',$useId)->where('emp_id',$emp->id)->first();
        // return $view;
        return view('employe.leave.view',compact('view'));
    } 

    public function history($slug){
        $userId = Crypt::decrypt($slug);
        // return $userId;
        $employe = Employee::where('id',$userId)->first();

        $leavehistory = Leave::where('emp_id',$employe->id)->orderBy('created_at','DESC')->get();
        // return $leavehistory;
        return view('employe.leave.history',compact('leavehistory'));
    }

    public function historyMonth($slug){
        // return $slug;
        $date = new DateTime($slug);
        $parseDate = Carbon::parse($date);
        // return $parseDate;
        $leavehistory = Leave::where('emp_id',Auth::guard('employee')->user()->id)->whereMonth('start_date',$parseDate->month)->orderBy('created_at','DESC')->get();
        // return $leavehistory;
        return view('employe.leave.historyMonth',compact(['leavehistory','parseDate']));
    }

    public function historyYear($slug){
        // return $slug;
        $date = new DateTime($slug);
        $parseDate = Carbon::parse($date);
        // return $parseDate;/
        $leavehistory = Leave::where('emp_id',Auth::guard('employee')->user()->id)->whereYear('start_date',$parseDate->year)->orderBy('created_at','DESC')->get();
        // return $leavehistory;
        return view('employe.leave.historyYear',compact(['leavehistory','parseDate']));
    }
}
