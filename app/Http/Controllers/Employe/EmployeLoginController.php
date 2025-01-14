<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeLoginController extends Controller
{

    public function loginEmploye(){
        return view('employe.login');
    }

    public function loginSubmit(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $credential = $request->only('email','password');
        // return $credential;
        // dd($credential, Auth::guard('employee')->attempt($credential));
        if(Auth::guard('employee')->attempt($credential)){
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['email' => 'Invalid email','password'=>'Password Not matched']);
    }

    public function logout()
    {
        // Auth::guard('customer')->logout();
        Auth::guard('employee')->logout();
        return redirect()->route('.');
    }

    public function insert(Request $request) {
        // Validation
        $request->validate([
            'leave_type' => 'required',
            'start' => 'required|date',
            'reason' => 'required',
            'end' => 'required|date|after_or_equal:start',
        ]);
    
        $definedLeave = EmployeLeaveSetting::where('id', 1)->first();
        $lastLeave = Leave::latest('id')->first();
    
        if ($lastLeave === null || $lastLeave->status != 1) {
            // Convert English date into Unix timestamp
            $start_time = strtotime($request['start']);
            $end_time = strtotime($request['end']);
            $curr = strtotime(date('Y-m-d'));
    
            // Check if the date range is valid
            if ($start_time <= $end_time && $start_time >= $curr) {
                // **NEW CONDITION: Check for overlapping leaves**
                $overlappingLeaves = Leave::where('emp_id', Auth::guard('employee')->user()->id)
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
    
                // Existing logic for leave calculations and insertion
                function countDaysExcludingDynamicAndWeeklyOffs($startDate, $endDate, $weeklyOffs = [], $specialOffDates = []) {
                    // Logic to count days excluding offs
                }
    
                function calculateLeaves($startDate, $endDate, $weeklyOffs = [], $specialOffDates = []) {
                    // Logic to calculate leaves per month
                }
    
                $startDate = $request['start'];
                $endDate = $request['end'];
                $weeklyOffs = [$definedLeave->weekoffday];
                $specialOffDates = explode(',', $definedLeave->specialoffday);
    
                usort($specialOffDates, function ($a, $b) {
                    return strtotime($a) - strtotime($b);
                });
    
                $leaveSummary = calculateLeaves($startDate, $endDate, $weeklyOffs, $specialOffDates);
    
                foreach ($leaveSummary as $leavePermonth) {
                    $start_date = Carbon::parse($leavePermonth['start_date']);
                    $end_date = Carbon::parse($leavePermonth['end_date']);
    
                    $checkMonth = Leave::where('emp_id', Auth::guard('employee')->user()->id)
                        ->where('status', 2)
                        ->whereMonth('start_date', $start_date->month)
                        ->whereYear('start_date', $start_date->year)
                        ->sum('total_paid');
    
                    $checkYear = Leave::where('emp_id', Auth::guard('employee')->user()->id)
                        ->where('status', 2)
                        ->whereYear('start_date', $start_date->year)
                        ->sum('total_paid');
    
                    $remainingMonthlyPaidLeave = max(0, $definedLeave->month_limit - $checkMonth);
                    $paidLeaves = min($remainingMonthlyPaidLeave, $leavePermonth['totalDays']);
                    $unPaidLeaves = $leavePermonth['totalDays'] - $paidLeaves;
    
                    $insert = Leave::create([
                        'leave_type_id' => $request['leave_type'],
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'reason' => $request['reason'],
                        'total_leave_this_month' => $paidLeaves + $unPaidLeaves,
                        'total_paid' => $paidLeaves,
                        'total_unpaid' => $unPaidLeaves > 0 ? $unPaidLeaves : null,
                        'unpaid_request' => $unPaidLeaves > 0 ? 1 : 0,
                        'emp_id' => Auth::guard('employee')->user()->id,
                        'slug' => 'leav-' . uniqid(),
                        'created_at' => Carbon::now(),
                    ]);
    
                    Mail::to('mjrcoder7@gmail.com')->send(new LeaveMailToAdmin($insert));
    
                    if ($insert) {
                        Session::flash('success', $unPaidLeaves > 0
                            ? 'Monthly leave limit reached! Extra days counted as unpaid.'
                            : 'Application Sent to SuperAdmin');
                    }
                }
    
                return redirect()->route('dashboard.leave.history', Auth::guard('employee')->user()->emp_slug);
            }
    
            Session::flash('error', 'Date is not correct!');
            return redirect()->route('dashboard.leave.add');
        }
    
        Session::flash('error', 'Your last leave request is still pending.');
        return redirect()->route('dashboard.leave.add');
    }
    
}
