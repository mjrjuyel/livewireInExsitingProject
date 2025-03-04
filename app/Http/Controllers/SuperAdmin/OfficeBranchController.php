<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\OfficeBranch;
use Carbon\Carbon;
use Session;
use Auth;

class OfficeBranchController extends Controller
{
       
    public function __construct(){
        $this->middleware('permission:Add Office Branch')->only('add','insert');
        $this->middleware('permission:Edit Office Branch')->only('edit','update');
        $this->middleware('permission:View Office Branch')->only('view','index');
        $this->middleware('permission:Delete Office Branch')->only('delete');
    }

    public function index(){
        $officeBranch = OfficeBranch::all();
        
        return view('superadmin.office_branch.index',compact('officeBranch'));
    }
    
    public function add(){
        return view('superadmin.office_branch.add');
    }
    
    public function insert(Request $request){
        $request->validate([
            'name'=>'required | unique:office_branches,branch_name,',
        ]);

        $insert=OfficeBranch::create([
            'branch_name'=>$request['name'],
            'branch_creator'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','New Ofice Branch Insert This Application');
            return redirect()->back();
        }
    }

    // Role  Update
    public function edit($id){
        $userId = Crypt::decrypt($id);
        $edit = OfficeBranch::where('id',$userId)->first();
        return view('superadmin.office_branch.edit',compact('edit'));
    }

    public function update(Request $request){

        $id = $request['id'];

        $request->validate([
            'name'=>'required | unique:office_branches,branch_name,'.$id,
        ]);

        $update = OfficeBranch::where('id',$id)->update([
            'branch_name'=>$request['name'],
            'branch_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Branch Detail Updated');
            return redirect()->back();
        }
    }

    public function view($id){
        $userId = Crypt::decrypt($id);
        $view = OfficeBranch::where('id',$userId)->first();
        return view('superadmin.office_branch.view',compact('view'));
    }

    public function delete(Request $request){

        $delete = OfficeBranch::findOrFail($request->id);
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('error','One Branch Delete From The Application');
        return redirect()->back();
        }
    }
}