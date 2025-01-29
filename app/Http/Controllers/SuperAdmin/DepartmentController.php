<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Department;
use Carbon\Carbon;
use Session;
use Auth;

class DepartmentController extends Controller
{
       
    //  All Role 
    public function index(){
        $department = Department::with('designation','employe')->get();
        // return $role;
        return view('superadmin.department.index',compact('department'));
    }
    // role Add
    public function add(){
        return view('superadmin.department.add');
    }
    
    public function insert(Request $request){
        $request->validate([
            'name'=>'required | unique:departments,depart_name,',
        ]);

        $insert=Department::create([
            'depart_name'=>$request['name'],
            'depart_creator'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','New Department Insert in This Application');
            return redirect()->back();
        }
    }

    // Role  Update
    public function edit($id){
        $userId = Crypt::decrypt($id);
        $edit = Department::where('id',$userId)->first();
        return view('superadmin.department.edit',compact('edit'));
    }

    public function update(Request $request){

        $id = $request['id'];

        $request->validate([
            'name'=>'required | unique:departments,depart_name,'.$id,
        ]);

        $update = Department::where('id',$id)->update([
            'depart_name'=>$request['name'],
            'depart_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Department Detail Updated');
            return redirect()->back();
        }
    }

    public function view($id){
        $userId = Crypt::decrypt($id);
        $view = Department::with(['designation','employe'])->where('id',$userId)->first();
        return view('superadmin.department.view',compact('view'));
    }

    public function delete(Request $request){

        $delete = Department::findOrFail($request->id);
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('error','One Department Information Delete From The Application');
        return redirect()->back();
        }
    }
}
