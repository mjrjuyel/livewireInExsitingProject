<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\UserRole;
use App\Models\Leave;
use App\Models\CateringFood;
use App\Models\CateringPayment;
use App\Models\DailyReport;
use App\Models\User;

class RecyclebinController extends Controller
{
    public function __construct(){
        $this->middleware('permission:Recycle Bin')->only('dashboard','employe','dailyreport');
    }
    public function dashboard(){
        $activeEmploye = User::where('status',0)->latest('id')->count();
        $dailyReport = DailyReport::where('status',0)->latest('id')->count();
        // $role = UserRole::count();
        // $leaveRequestInMonth = Leave::whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
        // $leaveRequestInYear = Leave::whereYear('start_date',date('Y'))->count();
        // $leaveRequestInPending = Leave::whereYear('start_date',date('Y'))->where('status',1)->count();
        // $leaveRequestInApproved = Leave::whereYear('start_date',date('Y'))->where('status',2)->count();
        // $leaveRequestInCancled = Leave::whereYear('start_date',date('Y'))->where('status',3)->count();
        // $curFoodCost = CateringFood::whereMonth('order_date',now()->month)->whereYear('order_date',now()->year)->sum('total_cost');
        // $curTotalPay = CateringPayment::whereMonth('payment_date',now()->month)->whereYear('payment_date',now()->year)->sum('payment');
        // return $dailyReport;
        return view('superadmin.recyclebin.recyclebin',compact(['activeEmploye','dailyReport']));
    }

    public function employe(){
        $employe = User::with(['emp_desig:id,title'])->where('status',0)->latest('id')->get();
        // return $employe;
        return view('superadmin.recyclebin.admin.index',compact('employe'));
    }

    public function dailyreport(){
        $reports = DailyReport::with(['employe'])->where('status',0)->latest('id')->get();
        // return $reports;
        return view('superadmin.recyclebin.dailyreport.index',compact('reports'));
    }
}
