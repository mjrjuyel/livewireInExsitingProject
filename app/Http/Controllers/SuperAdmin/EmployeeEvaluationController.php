<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\EmployeePromotion;
use App\Models\EmployeeEvaluation;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Design;
use carbon\Carbon;
use Auth;
use Session;

class EmployeeEvaluationController extends Controller
{
    public function index($id){
        $userId = Crypt::decrypt($id);
        $allEvaluation = EmployeeEvaluation::where('emp_id',20)->latest('id')->get();
        // return $allEvaluation->renewed_at->format('Y-m-d');
        // dd($allEvaluation->toSql(), $allEvaluation->getBindings());
        $view = Employee::findOrFail($userId);
        // return $view;
        return view('superadmin.employeEvaluation.index',compact(['allEvaluation','view']));
    }
     public function insert(Request $request){
        $request->validate([
            'employe'=>'required',
            'eva_last_date'=>'required',
            'eva_next_date'=>'required',
        ]);
    //    return $request->all();
        if($request->eva_last_date < $request->eva_next_date){
            $insert = EmployeeEvaluation::create([
                'emp_id'=>$request->employe,
                'eva_last_date'=>$request->eva_last_date,
                'eva_next_date'=>$request->eva_next_date,
                'evaluated_by'=>Auth::user()->id,
                'renewed_at'=>Carbon::now('UTC')->toDateString(),
                'created_at'=>Carbon::now('UTC'),
            ]);
            if($insert){
                Session::flash('success','Employee Evalution Renewed By Admin ');
                return redirect()->back();
            }
        }
        Session::flash('error','Evaluation LastDate is over from Evaluation Next Date');
        return redirect()->back();
    }

    public function edit($id){
        $dataId = Crypt::decrypt($id);
        $edit = EmployeeEvaluation::findOrFail($dataId);
        return view('superadmin.employeEvaluation.edit',compact(['edit']));
    }

    public function update(Request $request){

            $id = $request->id;
        
        //    return $request->all();
        // if($request->eva_last_date < $request->eva_next_date){
            $update = EmployeeEvaluation::where('id',$id)->update([
                'emp_id'=>$request->employe,
                'eva_last_date'=>$request->eva_last_date,
                'eva_next_date'=>$request->eva_next_date,
                'evaluated_by'=>Auth::user()->id,
                'updated_at'=>Carbon::now('UTC'),
            ]);
            if($update){
                Session::flash('success','Employee Evalution Update By Admin ');
                return redirect()->back();
            }
        // }
        // Session::flash('error','Please Check Evaluation Last Date is over from Evaluation Next Date');
        // return redirect()->back();
    }
    public function delete(Request $request){

        $delete = EmployeeEvaluation::findOrFail($request->id);
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('error','Employe Evalution Data Delete');
        return redirect()->back();
        }
    }
}