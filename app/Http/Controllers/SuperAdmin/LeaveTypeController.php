<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;
use Carbon\Carbon;
use Session;

class LeaveTypeController extends Controller
{

    
    //  All Role 
    public function index(){
        $role = LeaveType::all();
        // return $role;
        return view('superadmin.leavetype.index',compact('role'));
    }
    // role Add
    public function add(){
        return view('superadmin.leavetype.add');
    }
    
    public function insert(Request $request){
        $request->validate([
            'name'=>'required',
        ]);

        $insert=LeaveType::create([
            'type_title'=>$request['name'],
            'created_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','New Leave Type inserted!');
            return redirect()->back();
        }
    }

    // Role  Update
    public function edit($id){
        $edit = LeaveType::where('id',$id)->first();
        return view('superadmin.leavetype.edit',compact('edit'));
    }

    public function update(Request $request){

        $id = $request['id'];

        $request->validate([
            'name'=>'required | unique:leave_types,name,'.$id,
        ]);

        $update = LeaveType::where('id',$id)->update([
            'type_title'=>$request['name'],
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Leave Type Updated!');
            return redirect()->back();
        }
    }

    public function view($id){
        $view = LeaveType::where('id',$id)->first();
        return view('superadmin.leavetype.view',compact('view'));
    }

    public function delete(Request $request){
        $delete = LeaveType::findOrFail($request->id);
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('success','Role Delete!');
        return redirect()->back();
        }
    }
}