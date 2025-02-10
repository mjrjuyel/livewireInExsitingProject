<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\UserRole;
use Spatie\Permission\Models\Role;
use App\Models\Leave;
use App\Models\CateringFood;
use App\Models\CateringPayment;

class SuperAdminController extends Controller
{
    public function dashboard(){
        $activeEmploye = Employee::where('emp_status',1)->count();
        $role = Role::count();
        $leaveRequestInMonth = Leave::whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
        $leaveRequestInYear = Leave::whereYear('start_date',date('Y'))->count();
        $leaveRequestInPending = Leave::whereYear('start_date',date('Y'))->where('status',1)->count();
        $leaveRequestInApproved = Leave::whereYear('start_date',date('Y'))->where('status',2)->count();
        $leaveTotalDayApprovedInYear = Leave::whereYear('start_date',date('Y'))->where('status',2)->sum('total_leave_this_month');
        $leaveTotalDayApprovedInMonth = Leave::whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->where('status',2)->sum('total_leave_this_month');
        $leaveRequestInCancled = Leave::whereYear('start_date',date('Y'))->where('status',3)->count();
        $curFoodCost = CateringFood::whereMonth('order_date',now()->month)->whereYear('order_date',now()->year)->sum('total_cost');
        $curTotalPay = CateringPayment::whereMonth('payment_date',now()->month)->whereYear('payment_date',now()->year)->sum('payment');
        // return $leaveTotalDayApprovedInMonth;
        return view('superadmin.dashboard.index',compact(['activeEmploye','role','leaveRequestInMonth','leaveRequestInYear','leaveRequestInPending','leaveRequestInApproved','leaveRequestInCancled','curFoodCost','curTotalPay','leaveTotalDayApprovedInYear','leaveTotalDayApprovedInMonth']));
    }

    
}