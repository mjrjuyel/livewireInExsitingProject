<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailToAdmin;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveToAdminNotification;
use Illuminate\Support\Facades\Validator;
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

    public function leavTypeList(){
        $leaveType = LeaveType::get(['id','type_title']);

        return response()->json([
            'status'=>true,
            'message'=>'Leave Type List',
            'data'=>$leaveType,
        ]);
    }
    public function insert(Request $request){
       try{
            $validator=Validator::make($request->all(),[
                'leave_type'=>'required',
                'start'=>'required',
                'others'=>'max:50',
                'reason'=>'required',
                'end'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>true,
                    'message'=>"Unsuccesful To Inser!",
                    'error-message'=>$validator->errors(), 
                ]);
            }


            $definedLeave = EmployeLeaveSetting::where('id',1)->first();
            $lastLeave = Leave::latest('id')->where('emp_id',Auth::user()->id)->first();

            // if($lastLeave == Null || $lastLeave->status == 2 || $lastLeave->status == 3){

                // Convert English date into Unix time stamp 
            $start_time = strtotime($request['start']);
            $end_time = strtotime($request['end']);
            $currTime = strtotime(now());

            $before5Days = strtotime('-5 days', $currTime);
            // 2 dates are valid or not!
             if($start_time <= $end_time && $start_time >= $before5Days){
                        // **NEW CONDITION: Check for overlapping leaves**
                        $overlappingLeaves = Leave::where('emp_id', Auth::user()->id)->where('status',2)
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
                                return response()->json([
                                    'status'=>true,
                                    'message'=>'Your leave request overlaps with a previously submitted leave.',
                                ],201); 
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
                                $checkMonth = Leave::where('emp_id',Auth::user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('total_paid');
                                
                                $previousLeave = Leave::where('emp_id',Auth::user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->latest('id')->first();
                                // return $previousLeave !== null ? "this have value " : "Its A  null property";

                                // check total paid off in an annual year
                                $checkYear = Leave::where('emp_id',Auth::user()->id)->where('status',2)->whereYear('start_date',$start_date->year)->sum('total_paid');
                                
                                $remainingMonthlyPaidLeave = max(0, $definedLeave->month_limit - $checkMonth);

                                // return $remainingMonthlyPaidLeave;
                                $paidLeaves = min($remainingMonthlyPaidLeave,$leavePermonth['totalDays']);
                                // return $paidLeaves;
                                $unPaidLeaves = $leavePermonth['totalDays'] - $paidLeaves;

                              
                                if($request->unpaid){
                                    $insert = Leave::create([
                                        'leave_type_id'=>$request['leave_type'],
                                        'other_type'=>$request['leave_type'] == 0 ? $request->others : null,
                                        'start_date'=>Carbon::parse($leavePermonth['start_date'])->addHours(6),
                                        'end_date'=>Carbon::parse($leavePermonth['end_date'])->addHours(6),
                                        'reason'=>$request['reason'],
                                        'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                        // 'total_leave_this_month'=>($previousLeave && $previousLeave->total_leave_this_month !== null)? $previousLeave->total_leave_this_month + $paidLeaves + $unPaidLeaves : $paidLeaves + $unPaidLeaves,
                                        'total_paid'=>0,
                                        'total_unpaid'=>$paidLeaves + $unPaidLeaves,
                                        'unpaid_request'=>$request->unpaid,
                                        'emp_id'=>Auth::user()->id,
                                        'add_from'=>Auth::user()->name,
                                        'created_at'=>Carbon::now('UTC'),
                                    ]);

                                    $data = Leave::where('id',$insert->id)->first();
                                    $adminEmail = AdminEmail::first();

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
                                        return response()->json([
                                            'status'=>true,
                                            'message'=>"You Have Sent A Un-Paid Leave Application To Admin",
                                        ],201); 
                                    }
                                }else{
                                    $insert = Leave::create([
                                        'leave_type_id'=>$request['leave_type'],
                                        'other_type'=>$request['leave_type'] == 0 ? $request->others : null,
                                        'start_date'=>Carbon::parse($leavePermonth['start_date'])->addHours(6),
                                        'end_date'=>Carbon::parse($leavePermonth['end_date'])->addHours(6),
                                        'reason'=>$request['reason'],
                                        'total_leave_this_month'=> $paidLeaves + $unPaidLeaves,
                                        // 'total_leave_this_month'=>($previousLeave && $previousLeave->total_leave_this_month !== null)? $previousLeave->total_leave_this_month + $paidLeaves + $unPaidLeaves : $paidLeaves + $unPaidLeaves,
                                        'total_paid'=>$paidLeaves,
                                        'total_unpaid'=>$unPaidLeaves > 0 ? $unPaidLeaves : null,
                                        'unpaid_request'=>$request->unpaid,
                                        'emp_id'=>Auth::user()->id,
                                        'add_from'=>Auth::user()->name,
                                        'created_at'=>Carbon::now('UTC'),
                                    ]);

                                    $data = Leave::with(['leavetype:id,type_title'])->where('id',$insert->id)->first();
                                    
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
                                            Session::flash('success', 'Monthly leave limit reached! Extra days counted as unpaid.');
                                            return response()->json([
                                                'status'=>true,
                                                'message'=>"You Have Sent A Un-Paid Leave Application To Admin And Monthly leave limit reached! Extra days counted as unpaid.",
                                            ],201); 
                                        } else {
                                            return response()->json([
                                                'status'=>true,
                                                'message'=>"You Have Sent A Leave Application To Admin",
                                            ],201); 
                                        }
                                        
                                    }
                                }
                        
                            }

             }
                return response()->json([
                    'status'=>false,
                    'message'=>"Your Leave Start and End Date Are Not Correct!",
                ],201); 
            // }
       
        // return response()->json([
        //     'status'=>false,
        //     'message'=>"You Can't Sent Leave Request . Beacuse Already Your last Leave Request Is Pending",
        // ],201);
       }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>"failed to submit",
                'data'=>$e->getMessage(),
            ],201);
        }
    
            
    }

    public function update(Request $request){

            $id = $request->id;
                        $validator=Validator::make($request->all(),[
                            'leave_type'=>'required',
                            'start'=>'required',
                            'others'=>'max:50',
                            'reason'=>'required',
                        ]);

                        if($validator->fails()){
                            return response()->json([
                                'status'=>true,
                                'message'=>"Unsuccesful To Inser!",
                                'error-message'=>$validator->errors(), 
                            ]);
                        }

                        $definedLeave = EmployeLeaveSetting::where('id',1)->first();

                        // Convert English date into Unix time stamp 
                        $start_time = strtotime($request['start']);
                        $end_time = strtotime($request['end']);
                        $currTime = strtotime(now());

                    $before5Days = strtotime('-5 days', $currTime);
        
            if($start_time <= $end_time && $start_time >= $before5Days){
                // **NEW CONDITION: Check for overlapping leaves**
                    $overlappingLeaves = Leave::where('id','!=',$id)->where('emp_id', Auth::user()->id)->where('status',2)
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
                        return response()->json([
                            'status'=>true,
                            'message'=>'Your leave request overlaps with a previously submitted leave.',
                        ],201); 
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
                        $checkMonth = Leave::where('id','!=',$id)->where('emp_id',Auth::user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('total_paid');
                        
                        $previousLeave = Leave::where('id','!=',$id)->where('emp_id',Auth::user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->latest('id')->first();
                        // return $previousLeave !== null ? "this have value " : "Its A  null property";

                        // check total paid off in an annual year
                        $checkYear = Leave::where('id','!=',$id)->where('emp_id',Auth::user()->id)->where('status',2)->whereYear('start_date',$start_date->year)->sum('total_paid');
                        
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
                                            'emp_id'=>Auth::user()->id,
                                            'status'=>1,
                                            'add_from'=>Auth::user()->name,
                                            'updated_at'=>Carbon::now('UTC'),
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
                                            return response()->json([
                                                'status'=>true,
                                                'message'=>"You Have Edited and send Un-Paid Leave Request To Admin",
                                            ],201); 
                                        }
                                    }
                                    else{
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
                                                'emp_id'=>Auth::user()->id,
                                                'status'=>1,
                                                'add_from'=>Auth::user()->name,
                                                'updated_at'=>Carbon::now('UTC'),
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
                                                
                                                    return response()->json([
                                                        'status'=>true,
                                                        'message'=>"You Have Sent A Un-Paid Leave Application To Admin And Monthly leave limit reached! Extra days counted as unpaid.",
                                                    ],201); 
                                                } else {
                                                    return response()->json([
                                                        'status'=>true,
                                                        'message'=>"You Have Sent A Leave Application To Admin",
                                                    ],201); 
                                                }
                                            }
                            
                                    }
                }
            }
            return response()->json([
                'status'=>true,
                'message'=>"Your Leave Start and End Date Are Not Correct!",
            ],201); 
        
    }

    public function history(){
        $leavehistory = Leave::where('emp_id',auth()->user()->id)->orderBy('created_at','DESC')->latest('id')->paginate(10);

        $mappedData = $leavehistory->getCollection()->map(function ($leavehistory) {
                    return [
                    "id"=> $leavehistory->id,
                    "emp_id"=>  $leavehistory->emp_id,
                    "start_date"=> $leavehistory->start_date,
                    "end_date"=> $leavehistory->end_date,
                    "leave_type_id"=> $leavehistory->leave_type_id,
                    "other_type"=> $leavehistory->other_type,
                    "reason"=> $leavehistory->reason,
                    "status"=> $leavehistory->status,
                    "total_paid"=> $leavehistory->total_paid,
                    "unpaid_request"=>$leavehistory->unpaid_request,
                    "total_unpaid"=> $leavehistory->total_unpaid,
                    "add_from"=> $leavehistory->add_from,
                    "comments"=> $leavehistory->comments,
                    "editor"=> $leavehistory->editor,
                    'created_at' => $leavehistory->created_at,
                    'updated_at' => $leavehistory->updated_at,
                    
                ];
            });
        $response = [
            'success' => true,
            'message' => 'All Leave List I have Requested For Leave . Total Number is : ' . $leavehistory->count(),
            'data' => $mappedData,
            'pagination' => [
                'total' => $leavehistory->total(),
                'current_page' => $leavehistory->currentPage(),
                'last_page' => $leavehistory->lastPage(),
                'per_page' => $leavehistory->perPage(),
                'next_page_url' => $leavehistory->nextPageUrl(),
                'prev_page_url' => $leavehistory->previousPageUrl(),
            ],
        ];
        return response()->json($response);
       
    }
}
