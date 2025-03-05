<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeLeaveSetting;
use App\Models\UserRole;
use App\Models\Designation;
use App\Models\DailyReport;
use App\Models\EmployeePromotion;
use App\Models\EmployeeEvaluation;
use App\Models\EarlyLeave;
use Carbon\Carbon;
use Session;
use Auth;
use DateTime;

class DashboardController extends Controller
{
    public function index(){

        $userId = Auth::user()->id;
        $defaultLeave = EmployeLeaveSetting::first();
        $view = User::with(['reporting:id,name','department:id,depart_name','emp_desig:id,title','bankName:id,bank_name','bankBranch:id,bank_branch_name','officeBranch:id,branch_name','emp_creator:id,name','emp_editor:id,name'])->where('id',$userId)->first();
        // return $view;
        $whole_approved_leave = Leave::where('emp_id',$userId)->where('status',2)->sum('total_leave_this_month');
        $leaveRequestInMonth = Leave::where('emp_id',$userId)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
        $leaveRequestInYear = Leave::where('emp_id',$userId)->whereYear('start_date',date('Y'))->count();

        $paidRemainingMonth = Leave::where('emp_id',$userId)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_paid');
        $paidRemainingYear = Leave::where('emp_id',$userId)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_paid');

        $unpaidRemainingMonth = Leave::where('emp_id',$userId)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_unpaid');
        $unpaidRemainingYear = Leave::where('emp_id',$userId)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_unpaid');
        // Previous month Unpaid
        $unpaidPreviousMonth = Leave::where('emp_id', $userId)->where('status', 2)->whereMonth('start_date', now()->subMonth()->month)->whereYear('start_date', now('Y'))->sum('total_unpaid'); 


        $totalReportSubmit = DailyReport::where('submit_by',$userId)->count('id');

        $EmpEva = EmployeeEvaluation::where('emp_id',$view->id)->latest('renewed_at')->first();

        // return $EmpEva->eva_next_date;
         //Eva date Calculation
         if($EmpEva == null || $EmpEva->eva_next_date == ' '){
            // return 'No Eva Date';
            $end_date = new DateTime($view->join_date->format('Y-m-d'));
            $end_date->modify('+1 year');

            $start_date = new DateTime($view->join_date->format('Y-m-d'));

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
        $earlyleave = EarlyLeave::where('status',2)->where('emp_id',$userId)->whereMonth('leave_date',date('m'))->whereYear('leave_date',date('Y'))->sum('total_hour');
        $earlyleaveYear = EarlyLeave::where('status',2)->where('emp_id',$userId)->whereYear('leave_date',date('Y'))->sum('total_hour');
        $previousMonthEarlyLeave = EarlyLeave::where('status',2)->where('emp_id',$userId)->whereMonth('leave_date',now()->subMonth()->month)->whereYear('leave_date',date('Y'))->sum('total_hour');
 
        // special off day
        $explode = explode(',',$defaultLeave->specialoffday);
        usort($explode,function($a,$b){
            return strtotime($a) - strtotime($b);
        });
        $groupByMonth = [];
        
        $currentMonth = date('F');
        $nextMonth = date('F', strtotime('+1 month'));
        foreach($explode as $dates){
            $month = date('F',strtotime($dates));
            $groupByMonth[$month][]=$dates;
        }
        $filteredMonths = array_intersect_key($groupByMonth, array_flip([$currentMonth, $nextMonth]));
            //    return $groupByMonth;
        return view('employe.dashboard.index',compact(['view','leaveRequestInMonth','leaveRequestInYear','paidRemainingMonth','whole_approved_leave','paidRemainingYear','defaultLeave','unpaidRemainingMonth','unpaidRemainingYear','totalReportSubmit','Evaleaves','EmpEva','earlyleave','earlyleaveYear','filteredMonths','unpaidPreviousMonth','previousMonthEarlyLeave']));
    }
}