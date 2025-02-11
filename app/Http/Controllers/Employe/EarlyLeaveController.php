<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveMailToAdmin;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveToAdminNotification;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\EarlyLeave;
use App\Models\LeaveType;
use App\Models\EmployeLeaveSetting;
use App\Models\Employee;
use App\Models\AdminEmail;
use App\Models\User;
use App\Models\OfficeTime;
use Carbon\Carbon;
use Session;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;
use Exception;

class EarlyLeaveController extends Controller
{
    public function add(){
        $officeTime = OfficeTime::first();
        $leaveType = LeaveType::latest('id')->get();
        return view('employe.earlyleave.add',compact(['leaveType','officeTime']));
    }

    public function insert(Request $request){
        $request->validate([
            'leave_type'=>'required',
            'start'=>'required',
            'others'=>'max:50',
            'reason'=>'required',
        ]);

        if($rerquest->start < $request->end){
            return 'yes';
        }
        else{
            return "plz go back";
        }
    } 
}
