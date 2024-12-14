<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRole;
use Carbon\Carbon;
use Session;

class AdminRoleController extends Controller
{

    
    //  All Role 
    public function index(){
        $role = UserRole::with(['admin','employe'])->get();
        // return $role;
        return view('superadmin.role.index',compact('role'));
    }
    // role Add
    public function add(){
        return view('superadmin.role.add');
    }
    
    public function insert(Request $request){
        $request->validate([
            'name'=>'required | unique:user_roles,role_name',
        ]);

        $insert=UserRole::create([
            'role_name'=>$request['name'],
            'created_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','New Role inserted!');
            return redirect()->back();
        }
    }

    // Role  Update
    public function edit($id){
        $edit = UserRole::where('id',$id)->first();
        return view('superadmin.role.edit',compact('edit'));
    }

    public function update(Request $request){

        $id = $request['id'];

        $request->validate([
            'name'=>'required | unique:user_roles,role_name,'.$id,
        ]);

        $update = UserRole::where('id',$id)->update([
            'role_name'=>$request['name'],
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Role Name Updated!');
            return redirect()->back();
        }
    }

    public function view($id){
        $view = UserRole::with(['employe','admin'])->where('id',$id)->first();
        return view('superadmin.role.view',compact('view'));
    }

    public function delete($id){
        $delete = UserRole::where('id',$id)->first();
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
