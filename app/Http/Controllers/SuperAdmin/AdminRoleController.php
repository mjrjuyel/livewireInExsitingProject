<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\UserRole;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

use Carbon\Carbon;
use Session;

class AdminRoleController extends Controller
{
    public function __construct(){
        $this->middleware('permission:All Role')->only('index');
        $this->middleware('permission:Add Role')->only('add','insert');
        $this->middleware('permission:Edit Role')->only('edit','update');
        $this->middleware('permission:View Role')->only('view','index');
        $this->middleware('permission:Delete Role')->only('delete');
    }
    
    //  All Role 
    public function index(){
        $roles = Role::with('permissions')->get();
        // return $roles;
        return view('superadmin.role-permission.role.index',compact('roles'));
    }
    // role Add
    public function add(){
        $permissions = Permission::all();
        // return $permissions;
        return view('superadmin.role-permission.role.add',compact('permissions'));
    }
    
    public function insert(Request $request){
        
        // return $request->all();
        $request->validate([
            'name'=>'required | unique:roles,name',
        ]);

        $insert=Role::create([
            'name'=>$request['name'],
            'created_at'=>Carbon::now(),
        ]);

        $insert->syncPermissions($request->permission);

        if($insert){
            Session::flash('success','New Role Add And Assigned with Permission');
            return redirect()->route('portal.role');
        }
    }

    // Role  Update
    public function edit($id){
        $ID = Crypt::decrypt($id);
        $edit = Role::where('id',$ID)->first();

        $permissions = Permission::all();
        $rolePermission = DB::table('role_has_permissions')->where('role_id',$ID)->pluck('permission_id')->all();

        // return $per;
        return view('superadmin.role-permission.role.edit',compact(['edit','permissions','rolePermission']));
    }

    public function update(Request $request){

        $id = $request['id'];

        $request->validate([
            'name'=>'required | unique:roles,name,'.$id,
            'permission'=>'required',
        ]);
        // return $request->all();
        $update = Role::where('id',$id)->update([
            'name'=>$request['name'],
            'updated_at'=>Carbon::now(),
        ]);

        $user = Role::where('id',$id)->first();
        $user->syncPermissions($request->permission);

        if($update){
            Session::flash('success','Update Role And Assigned with Permission');
            return redirect()->back();
        }
    }

    public function view($id){
        $ID = Crypt::decrypt($id);
        $view = Role::where('id',$ID)->first();
        // return $view;
        return view('superadmin.role-permission.role.view',compact('view'));
    }

    public function delete(Request $request){
        $id = $request->id;

        $delete = Role::findOrFail($id);
        $delete->delete();
        if($delete){
            Session::flash('success','Role Have Deleted');
            return redirect()->back();
        }
    }
}
