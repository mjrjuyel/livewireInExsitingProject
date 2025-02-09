<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\EmployeePromotion;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Design;
use carbon\Carbon;
use Auth;
use Session;

class EmployeePromotionController extends Controller
{
    public function index($id){
        $userId = Crypt::decrypt($id);
        $allPromotion = EmployeePromotion::where('emp_id',$userId)->orderBy('pro_date','DESC')->get();
        $view = Employee::find(1);
        $departs = Department::all();
        $designs = Designation::all();
        return view('superadmin.employePromotion.index',compact(['allPromotion','view','departs','designs']));
    }
     public function insert(Request $request){

        $depart = Designation::where('id',$request->desig)->first('depart_id');
        // return $depart;
        $insert = EmployeePromotion::create([
            'emp_id'=>$request->employe,
            'depart_id'=>$depart->depart_id,
            'desig_id'=>$request->desig,
            'emp_type'=>$request->empType,
            'pro_status'=>$request->status,
            'salary'=>$request->salary,
            'promoted_by'=>Auth::user()->id,
            'pro_date' => Carbon::now('UTC')->toDateString(),
            'created_at'=>Carbon::now('UTC'),
        ]);

        if($insert){
            Session::flash('success','Employee Designation Update');
            return redirect()->back();
        }
    }

    public function edit($id){
        $dataId = Crypt::decrypt($id);
        $edit = EmployeePromotion::findOrFail($dataId);

        $departs = Department::all();
        $designs = Designation::all();
        // return $data;
        return view('superadmin.employePromotion.edit',compact(['edit','departs','designs']));
    }

    public function update(Request $request){

        $id = $request->id;
        $depart = Designation::where('id',$request->desig)->first('depart_id');
        // return $depart;
        $insert = EmployeePromotion::where('id',$id)->update([
            'emp_id'=>$request->employe,
            'depart_id'=>$depart->depart_id,
            'desig_id'=>$request->desig,
            'emp_type'=>$request->empType,
            'pro_status'=>$request->status,
            'salary'=>$request->salary,
            'promoted_by'=>Auth::user()->id,
            'pro_date' => Carbon::now('UTC')->toDateString(),
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($insert){
            Session::flash('success','Employee Promotion Update');
            return redirect()->route('admin.promotion',Crypt::encrypt($id));
        }
    }
}
