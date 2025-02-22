<?php

namespace App\Http\Controllers\Api;

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
use App\Models\EarlyLeave;
use Carbon\Carbon;
use Session;
use Auth;
use DateTime;
use Exception;

class EmployeeDashboardController extends Controller
{
    public function index(){

        try{
            $userId = $id = auth('sanctum')->user()->id;
            $defaultLeave = EmployeLeaveSetting::first();
            $view = Employee::with(['creator:id,name','emp_desig:id,title'])->where('id',$userId)->first();

            $whole_approved_leave = Leave::where('emp_id',$userId)->where('status',2)->sum('total_leave_this_month');
            $leaveRequestInMonth = Leave::where('emp_id',$userId)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
            $leaveRequestInYear = Leave::where('emp_id',$userId)->whereYear('start_date',date('Y'))->count();

            $paidRemainingMonth = Leave::where('emp_id',$userId)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_paid');
            $paidRemainingYear = Leave::where('emp_id',$userId)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_paid');

            $unpaidRemainingMonth = Leave::where('emp_id',$userId)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_unpaid');
            $unpaidRemainingYear = Leave::where('emp_id',$userId)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_unpaid');

            $totalReportSubmit = DailyReport::where('submit_by',$userId)->count('id');

            $last_employe_evaluation = EmployeeEvaluation::where('emp_id',$view->id)->latest('renewed_at')->first();

            // return $last_employe_evaluation->eva_next_date;
            //Eva date Calculation
            if($last_employe_evaluation == null || $last_employe_evaluation->eva_next_date == ' '){
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
                    ->where(function ($query) use ($last_employe_evaluation) {
                        $query->whereBetween('start_date', [$last_employe_evaluation->eva_last_date, $last_employe_evaluation->eva_next_date])
                            ->whereBetween('end_date', [$last_employe_evaluation->eva_last_date , $last_employe_evaluation->eva_next_date]);
                    })
                    ->get();
                }
            
            $activeDesig = EmployeePromotion::where('emp_id',$view->id)->latest('pro_date')->first();
            $earlyleave = EarlyLeave::where('status',2)->where('emp_id',$userId)->whereMonth('leave_date',date('m'))->whereYear('leave_date',date('Y'))->sum('total_hour');
            $earlyleaveYear = EarlyLeave::where('status',2)->where('emp_id',$userId)->whereYear('leave_date',date('Y'))->sum('total_hour');
            // return $earlyleave;

            // Speacial LLEave List
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

            return response()->json([
                'status'=>true,
                'message'=>'All Employee Dashboard Details',
                'employee_view' => $view,
                'leave_request_in_month'=>$leaveRequestInMonth,
                'leave_request_in_year'=>$leaveRequestInYear,
                'paid_remaining_month'=>$paidRemainingMonth,
                'whole_approved_leave'=>$whole_approved_leave,
                'paid_remaining_year'=>$paidRemainingYear,
                'default_leave'=>$defaultLeave,
                'unpaid_remaining_month'=>$unpaidRemainingMonth,
                'unpaid_remaining_year'=>$unpaidRemainingYear,
                'total_report_submit'=>$totalReportSubmit,
                'evaluation_leaves'=>$Evaleaves,
                'last_employe_evaluation'=>$last_employe_evaluation,
                'early_leave'=>$earlyleave,
                'early_leave_year'=>$earlyleaveYear,
                'group_by_month'=>$filteredMonths,

            ],200);
        }
        catch(Exception $e){
            return response()->json([
            'status'=> false,
            'message'=> 'Failed to fetch Data',
            'data'=>$e->getMessage(),
            ]);
        }
    }
}
