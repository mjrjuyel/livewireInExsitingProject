<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\BankName;
use App\Models\BankBranch;
use Carbon\Carbon;
use Session;
use Auth;

class BankBranchController extends Controller
{
       
    //  All Role 
    public function index(){
        $bankBranch = BankBranch::with('bankName')->get();
        // return $bankBranch;
        return view('superadmin.bank.branch.index',compact('bankBranch'));
    }
    // role Add
    public function add(){
        $bankName = BankName::latest('id')->get();
        return view('superadmin.bank.branch.add',compact('bankName'));
    }
    
    public function insert(Request $request){
        $request->validate([
            'bank_id'=>'required',
            'name'=>'required | unique:bank_branches,bank_branch_name,',
        ]);

        $insert=BankBranch::create([
            'bank_branch_name'=>$request['name'],
            'bank_id'=>$request['bank_id'],
            'bank_branch_creator'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','New Branch of a Bank Added');
            return redirect()->back();
        }
    }

    // Role  Update
    public function edit($id){
        $userId = Crypt::decrypt($id);
        $edit = BankBranch::where('id',$userId)->first();
        $bankName = Bankname::all();
        return view('superadmin.bank.branch.edit',compact(['edit','bankName']));
    }

    public function update(Request $request){

        $id = $request['id'];

        $request->validate([
            'bank_id'=>'required',
            'name'=>'required | unique:bank_branches,bank_branch_name,'.$id,
        ]);

        $update = BankBranch::where('id',$id)->update([
            'bank_id'=>$request['bank_id'],
            'bank_branch_name'=>$request['name'],
            'bank_branch_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Branche SuccessFully Updated');
            return redirect()->back();
        }
    }

    public function view($id){
        $userId = Crypt::decrypt($id);
        $view = BankBranch::with('bankName')->where('id',$userId)->first();
        return view('superadmin.bank.branch.view',compact('view'));
    }

    public function delete($id){
        $userId = Crypt::decrypt($id);
        $delete = BankBranch::where('id',$userId)->first();
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('error','One Bank Information Delete From The Application');
        return redirect()->back();
        }
    }
}
