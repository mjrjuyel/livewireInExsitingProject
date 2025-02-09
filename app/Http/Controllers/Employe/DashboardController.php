<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\EmployeLeaveSetting;
use App\Models\UserRole;
use App\Models\Designation;
use App\Models\DailyReport;
use App\Models\EmployeePromotion;
use App\Models\EmployeeEvaluation;
use Carbon\Carbon;
use Session;
use Auth;
use DateTime;

class DashboardController extends Controller
{
    public function index(){

        $defaultLeave = EmployeLeaveSetting::first();
        $view = Employee::with(['emp_role','emp_desig','creator'])->where('id',Auth::guard('employee')->user()->id)->first();

        $whole_approved_leave = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->sum('total_leave_this_month');
        $leaveRequestInMonth = Leave::where('emp_id',Auth::guard('employee')->user()->id)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
        $leaveRequestInYear = Leave::where('emp_id',Auth::guard('employee')->user()->id)->whereYear('start_date',date('Y'))->count();

        $paidRemainingMonth = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_paid');
        $paidRemainingYear = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_paid');

        $unpaidRemainingMonth = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_unpaid');
        $unpaidRemainingYear = Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_unpaid');

        $totalReportSubmit = DailyReport::where('submit_by',Auth::guard('employee')->user()->id)->count('id');

        $EmpEva = EmployeeEvaluation::where('emp_id',$view->id)->latest('renewed_at')->first();

        // return $EmpEva->eva_next_date;
         //Eva date Calculation
         if($EmpEva == null || $EmpEva->eva_next_date == ' '){
            // return 'No Eva Date';
            $end_date = new DateTime($view->emp_join->format('Y-m-d'));
            $end_date->modify('+1 year');

            $start_date = new DateTime($view->emp_join->format('Y-m-d'));

            $formatted_start_date = $start_date->format('Y-m-d');
            $formatted_end_date = $end_date->format('Y-m-d');
        
            // Leave calculation (Paid/Unpaid)
            $Evaleaves = Leave::where('emp_id', $view->id)->where('status',2)
            ->where(function ($query) use ($formatted_start_date, $formatted_end_date) {
                $query->whereBetween('start_date', [$formatted_start_date, $formatted_end_date])
                      ->whereBetween('end_date', [$formatted_start_date, $formatted_end_date]);
            })->get();
            }
            else{
                
                $Evaleaves = Leave::where('emp_id', $view->id)
                ->where('status', 2)
                ->where(function ($query) use ($EmpEva) {
                    $query->whereBetween('start_date', [$EmpEva->eva_last_date, $EmpEva->eva_next_date])
                          ->whereBetween('end_date', [$EmpEva->eva_last_date , $EmpEva->eva_next_date]);
                })
                ->get();
            }
        
        $activeDesig = EmployeePromotion::where('emp_id',$view->id)->latest('pro_date')->first();

        return view('employe.dashboard.index',compact(['view','leaveRequestInMonth','leaveRequestInYear','paidRemainingMonth','whole_approved_leave','paidRemainingYear','defaultLeave','unpaidRemainingMonth','unpaidRemainingYear','totalReportSubmit','Evaleaves','EmpEva']));
    }
}