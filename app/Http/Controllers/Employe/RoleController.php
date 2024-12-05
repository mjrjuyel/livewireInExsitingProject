<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRole;
use Carbon\Carbon;
use Session;

class RoleController extends Controller
{
    public function add(){
        return view('admin.role.add');
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
            Session::flash('success','Role inserted!');
            return redirect()->back();
        }
    }
    //  All Role 
    public function index(){
        $role = UserRole::with('admin')->get();
        // return $role;
        return view('admin.role.index',compact('role'));
    }

    public function view($id){
        $view = UserRole::where('id',$id)->first();
        return view('admin.role.view',compact('view'));
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