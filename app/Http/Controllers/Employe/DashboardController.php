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
use Carbon\Carbon;
use Session;
use Auth;

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

        return view('employe.dashboard.index',compact(['view','leaveRequestInMonth','leaveRequestInYear','paidRemainingMonth','whole_approved_leave','paidRemainingYear','defaultLeave','unpaidRemainingMonth','unpaidRemainingYear','totalReportSubmit']));
    }
}