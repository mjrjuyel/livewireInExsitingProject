<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\UserRole;
use App\Models\Leave;
use App\Models\CateringFood;
use App\Models\CateringPayment;

class SuperAdminController extends Controller
{
    public function dashboard(){
        $activeEmploye = Employee::count();
        $notifications = auth()->user()->notifications;
        $role = UserRole::count();
        $leaveRequestInMonth = Leave::whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
        $leaveRequestInYear = Leave::whereYear('start_date',date('Y'))->count();
        $leaveRequestInPending = Leave::whereYear('start_date',date('Y'))->where('status',1)->count();
        $leaveRequestInApproved = Leave::whereYear('start_date',date('Y'))->where('status',2)->count();
        $leaveRequestInCancled = Leave::whereYear('start_date',date('Y'))->where('status',3)->count();
        $curFoodCost = CateringFood::whereMonth('order_date',now()->month)->whereYear('order_date',now()->year)->sum('total_cost');
        $curTotalPay = CateringPayment::whereMonth('payment_date',now()->month)->whereYear('payment_date',now()->year)->sum('payment');
        // return $curTotalPay;
        return view('superadmin.dashboard.index',compact(['notifications','activeEmploye','role','leaveRequestInMonth','leaveRequestInYear','leaveRequestInPending','leaveRequestInApproved','leaveRequestInCancled','curFoodCost','curTotalPay']));
    }

    public function insert(Request $request){
        // validation
            $request->validate([
                'start'=>'required',
                'reason'=>'required',
                'end'=>'required',
            ]);
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

            // Data Pass With The Count FUnction
            $startDate = $request->start;
            $endDate = $request->end;

            // Define weekly offs (e.g., 5 = Friday)
            $weeklyOffs = [$definedLeave->weekoffday]; // Every Friday

            // explode speacial off day
            // speacial off Day with Govt Day
            $specialOffDates = explode(',',$definedLeave->specialoffday);

            // sort by ascending
            usort($specialOffDates,function($a,$b){
                return strtotime($a) - strtotime($b);
            });
            
            // get Total day
            $totalDays = countDaysExcludingDynamicAndWeeklyOffs($startDate,$endDate,$weeklyOffs,$specialOffDates);

            // Request leave days are more than 3 or not!
            if($totalDays <= $definedLeave->month_limit){

                $start_date = Carbon::parse($request->start); // Parsing day in Month, year;

                // check total Paid of in a month
                $checkMonth = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',$start_date->month)->whereYear('start_date',$start_date->year)->sum('total_day');

                // check total paid off in an annual year
                $checkYear = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereYear('start_date',$start_date->year)->sum('total_day');
                
                // return $checkMonth;
                if($checkYear + $totalDays <= $definedLeave->year_limit){
                    // if total day pass the year 

                    if($checkMonth + $totalDays <= $definedLeave->month_limit){
                        // if it has paid monthly leave .
                        $insert = Leave::create([
                            'leave_type_id'=>$request['leave_type'],
                            'start_date'=>Carbon::parse($request->start),
                            'end_date'=>$request['end'],
                            'reason'=>$request['reason'],
                            'total_day'=>$totalDays,
                            'emp_id'=>Auth::guard('employee')->user()->id,
                            'slug'=>'leav-'.uniqId(),
                            'created_at'=>Carbon::now(),
                        ]);

                        // Send Mail to Admin
                        Mail::to('mjrcoder7@gmail.com')->send(new LeaveMailToAdmin($insert));
                        
                        if($insert){
                            Session::flash('success','Application Sent To SuperAdmin');
                            return redirect()->route('dashboard.leave.view',$insert->slug); 
                        }
                    }else{
                        // leave for unpaid
                        // return $totalDays . "you applied for unpaid leave month";
                        $insert = Leave::create([
                            'leave_type_id'=>$request['leave_type'],
                            'start_date'=>Carbon::parse($request->start),
                            'end_date'=>$request['end'],
                            'reason'=>$request['reason'],
                            'total_day'=>$totalDays,
                            'unpaid_request'=>1,
                            'emp_id'=>Auth::guard('employee')->user()->id,
                            'slug'=>'leav-'.uniqId(),
                            'created_at'=>Carbon::now(),
                        ]);

                        Mail::to('mjrcoder7@gmail.com')->send(new LeaveMailToAdmin($insert));

                        if($insert){
                            Session::flash('error','Monthly leave limit reached!');
                            return redirect()->route('dashboard.leave.view',$insert->slug); 
                        }
                    }
                }else{
                    // leave for unpaid
                    // return $totalDays . "you applied for unpaid leave year";
                    $insert = Leave::create([
                        'leave_type_id'=>$request['leave_type'],
                        'start_date'=>Carbon::parse($request->start),
                        'end_date'=>$request['end'],
                        'reason'=>$request['reason'],
                        'total_unpaid'=>$totalDays,
                        'unpaid_request'=>1,
                        'emp_id'=>Auth::guard('employee')->user()->id,
                        'slug'=>'leav-'.uniqId(),
                        'created_at'=>Carbon::now(),
                    ]);
                    
                    Mail::to('mjrcoder7@gmail.com')->send(new LeaveMailToAdmin($insert));

                    if($insert){
                        Session::flash('success','You Applied For Unpaid Leave!');
                        return redirect()->route('dashboard.leave.view',$insert->slug); 
                    }
                    
                }
                
            }
            Session::flash('error','You cant request more than 3 days!');
           return redirect()->route('dashboard.leave.add'); 
        }

        Session::flash('error','Date Is not Correct!');
        return redirect()->route('dashboard.leave.add');
}
}