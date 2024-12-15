<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailToAdmin;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\EmployeLeaveSetting;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;



class LeaveFormController extends Controller
{
    public function add(){
        $leaveType = LeaveType::all();
        return view('employe.leave.add',compact('leaveType'));
    }

    // function countDaysExcludingDynamicAndWeeklyOffs($startDate, $endDate, $weeklyOffs = [], $specialOffDates = []) {
    //     // Create DateTime objects for the start and end dates
    //     $start = new DateTime($startDate);
    //     $end = new DateTime($endDate);

    //     // Include the end date in the calculation
    //     $end->modify('+1 day');

    //     // Create a DatePeriod with a 1-day interval
    //     $interval = new DateInterval('P1D');
    //     $period = new DatePeriod($start, $interval, $end);

    //     $totalDays = 0;

    //     // Iterate over each day in the period
    //         foreach ($period as $date) {
    //         // Exclude if the day is a weekly off OR a special off date
    //             if (!in_array($date->format('N'), $weeklyOffs) && !in_array($date->format('Y-m-d'), $specialOffDates)) {
    //                 $totalDays++;
    //                 }
    //         }

    //         return $totalDays;
    //     }

    //     function calculateLeaves($startDate, $endDate, $weeklyOffs, $specialOffDates) {
    //     $start = new DateTime($startDate);
    //     $end = new DateTime($endDate);

    //     $paidLeaveLimitPerMonth = 3;
    //     $totalPaidLeaveLimit = 14;
    //     $remainingPaidLeaves = $totalPaidLeaveLimit;

    //     $leaveSummary = [];
    //     $currentDate = $start;

    //     // Loop through each month in the range
    //     while ($currentDate <= $end) {
            
    //         $currentMonth=$currentDate->format('Y-m');
    //         $monthStart = new DateTime($currentDate->format('Y-m-01'));
    //         $monthEnd = new DateTime($currentDate->format('Y-m-t'));

    //         // Adjust the range for the first and last months
    //         $monthStart = max($currentDate, $monthStart);
    //         $monthEnd = min($end, $monthEnd);

    //         // Count valid leave days in the current month
    //         $daysInMonth = countDaysExcludingDynamicAndWeeklyOffs(
    //         $monthStart->format('Y-m-d'),
    //         $monthEnd->format('Y-m-d'),
    //         $weeklyOffs,
    //         $specialOffDates
    //         );

    //         // Determine paid and unpaid leaves for the month
    //         $paidLeaves = min($daysInMonth, $paidLeaveLimitPerMonth, $remainingPaidLeaves);
    //         $unpaidLeaves = $daysInMonth - $paidLeaves;

    //         // Reduce remaining paid leave balance
    //         $remainingPaidLeaves -= $paidLeaves;

    //         // Save the summary for the current month
    //         $leaveSummary[$currentMonth] = [
    //         'totalDays' => $daysInMonth,
    //         'paidLeaves' => $paidLeaves,
    //         'unpaidLeaves' => $unpaidLeaves,
    //         ];

    //         // Move to the next month
    //         $currentDate->modify('first day of next month');
    //         }

    //         return $leaveSummary;
    //         }

    //         // Example usage:
    //         $startDate = '2023-12-31';
    //         $endDate = '2024-01-02';

    //         // Define weekly offs (e.g., 7 = Sunday)
    //         $weeklyOffs = [7]; // Every Sunday

    //         // Define dynamic special off-days (specific dates)
    //         $specialOffDates = [
    //         '2023-12-25', // Example: Christmas
    //         '2024-01-01', // New Year's Day
    //         ];

    //         $leaveSummary = calculateLeaves($startDate, $endDate, $weeklyOffs, $specialOffDates);

    //         // Output the result
    //         foreach ($leaveSummary as $month => $details) {
    //         echo "Month: $month\n";
    //         echo "Total Leave Days: " . $details['totalDays'] . "\n";
    //         echo "Paid Leaves: " . $details['paidLeaves'] . "\n";
    //         echo "Unpaid Leaves: " . $details['unpaidLeaves'] . "\n";
    //         echo "--------------------------\n";
    //         }

    public function insert(Request $request){
                // validation

                // return $request->all();
                    // $request->validate([
                    //     'start'=>'required',
                    //     'reason'=>'required',
                    //     'end'=>'required',
                    // ]);

                    $definedLeave = EmployeLeaveSetting::where('id',1)->first();

                    // Convert English date into Unix time stamp 
                    $start_time = strtotime($request['start']);
                    $end_time = strtotime($request['end']);
                    $curr = strtotime('now');
            
                // 2 dates are valid or not!
                if($start_time <= $end_time && $start_time >= $curr){
                  
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

                            // Determine paid and unpaid leaves for the month
                            // $paidLeaves = min($daysInMonth, $paidLeaveLimitPerMonth, $remainingPaidLeaves);
                            // $unpaidLeaves = $daysInMonth - $paidLeaves;

                            // Reduce remaining paid leave balance
                            // $remainingPaidLeaves -= $paidLeaves;

                            // Save the summary for the current month
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
                    $weeklyOffs = [$definedLeave->weekoffday];

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
                            
                            // return $start_date;

                            // check total Paid of in a month
                            $checkMonth = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('total_day');
    
                            // check total paid off in an annual year
                            $checkYear = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereYear('start_date',$start_date->year)->sum('total_day');
                            
                            $remainingMonthlyPaidLeave = max(0, $definedLeave->month_limit - $checkMonth);

                            // return $remainingMonthlyPaidLeave;
                            $paidLeaves = min($remainingMonthlyPaidLeave,$leavePermonth['totalDays']);
                            // return $paidLeaves;
                            $unPaidLeaves = $leavePermonth['totalDays'] - $paidLeaves;

                            // return $paidLeaves . "Paid leave - nonpaid leaves " . $unPaidLeaves;

                                    $insert = Leave::create([
                                        'leave_type_id'=>$request['leave_type'],
                                        'start_date'=>Carbon::parse($leavePermonth['start_date']),
                                        'end_date'=>$leavePermonth['end_date'],
                                        'reason'=>$request['reason'],
                                        'total_day'=>$paidLeaves,
                                        'total_unpaid'=>$unPaidLeaves > 0 ? $unPaidLeaves : null,
                                        'unpaid_request'=>$unPaidLeaves > 0 ? 1 : 0,
                                        'emp_id'=>Auth::guard('employee')->user()->id,
                                        'slug'=>'leav-'.uniqId(),
                                        'created_at'=>Carbon::now(),
                                    ]);
            
                                    // Send Mail to Admin
                                    // Mail::to('mjrcoder7@gmail.com')->send(new LeaveMailToAdmin($insert));
                                    // return $insert;
                                    if ($insert) {
                                        if ($unPaidLeaves > 0) {
                                            Session::flash('error', 'Monthly leave limit reached! Extra days counted as unpaid.');
                                        } else {
                                            Session::flash('success', 'Application Sent to SuperAdmin');
                                        }
                                        
                                    }
                             
                    }

                    return redirect()->route('dashboard.leave.history',Auth::guard('employee')->user()->emp_slug);
                }
            Session::flash('error','Date Is not Correct!');
            return redirect()->route('dashboard.leave.add');
    }

    public function view($slug){
        $emp = Employee::where('emp_slug',Auth::guard('employee')->user()->emp_slug)->first();
        // dd($emp);
        $view = Leave::with(['employe','leavetype'])->where('emp_id',$emp->id)->where('slug',$slug)->first();
        return view('employe.leave.view',compact('view'));
    } 

    public function history($slug){
        $employe = Employee::where('emp_slug',$slug)->first();
        $leavehistory = Leave::where('emp_id',$employe->id)->latest('id')->get();
        // return $leavehistory;
        return view('employe.leave.history',compact('leavehistory'));
    }
}
