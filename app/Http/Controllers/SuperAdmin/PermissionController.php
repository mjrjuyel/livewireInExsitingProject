<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Session;
use Auth;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::with('roles')->get();
        // return $permissions;
        return view('superadmin.role-permission.permission.index',compact('permissions'));
    }

    public function add(){
        return view('superadmin.role-permission.permission.add');
    }
    
    public function insert(Request $request){
        
        // return $request->all();
        $request->validate([
            'name'=>'required | string | unique:permissions,name',
        ]);

        $insert = Permission::create([
            'name'=>$request['name'],
        ]);

        if($insert){
            Session::flash('success','Successfully Add New Permission');
            return redirect()->back();
        }
    }

    public function edit($id){
        $Id = Crypt::decrypt($id);
        $edit = Permission::where('id',$Id)->first();
        return view('superadmin.role-permission.permission.edit',compact('edit'));
    }
    
    public function update(Request $request){
        // return $request->all();
        $id = $request->id;
        $request->validate([
            'name'=>'required | string | unique:permissions,name,'.$id,
        ]);
        $update = Permission::where('id',$id)->update([
            'name'=>$request['name'],
        ]);
        if($update){
            Session::flash('success','Successfully Update Permission Name');
            return redirect()->back();
        }
    }

    public function view($id){
        $Id = Crypt::decrypt($id);
        $view = Permission::where('id',$Id)->first();
        return view('superadmin.role-permission.permission.view',compact('view'));
    }

    public function delete(Request $request){
        $id = $request->id;

        $delete = Permission::findOrFail($id);
        $delete->delete();

        if($delete){
            // $all = Permission::all();
            // foreach($all as $index => $value){
            //     $value->id = $index + 1;
            //     $value->save();
            // }
            Session::flash('success','Permission Have Deleted');
            return redirect()->back();
        }
    }
}
