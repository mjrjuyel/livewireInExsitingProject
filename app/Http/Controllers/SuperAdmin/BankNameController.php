<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\BankName;
use Carbon\Carbon;
use Session;
use Auth;

class BankNameController extends Controller
{
       
    //  All Role 
    public function index(){
        $bankName = BankName::all();
        // return $role;
        return view('superadmin.bank.name.index',compact('bankName'));
    }
    // role Add
    public function add(){
        return view('superadmin.bank.name.add');
    }
    
    public function insert(Request $request){
        $request->validate([
            'name'=>'required | unique:bank_names,bank_name,',
        ]);

        $insert=BankName::create([
            'bank_name'=>$request['name'],
            'bank_creator'=>Auth::user()->id,
            'created_at'=>Carbon::now('UTC'),
        ]);

        if($insert){
            Session::flash('success','New Bank Insert This Application');
            return redirect()->back();
        }
    }

    // Role  Update
    public function edit($id){
        $userId = Crypt::decrypt($id);
        $edit = BankName::where('id',$userId)->first();
        return view('superadmin.bank.name.edit',compact('edit'));
    }

    public function update(Request $request){

        $id = $request['id'];

        $request->validate([
            'name'=>'required | unique:bank_names,bank_name,'.$id,
        ]);

        $update = BankName::where('id',$id)->update([
            'bank_name'=>$request['name'],
            'bank_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($update){
            Session::flash('success','Bank Detail Updated');
            return redirect()->back();
        }
    }

    public function view($id){
        $userId = Crypt::decrypt($id);
        $view = BankName::where('id',$userId)->first();
        return view('superadmin.bank.name.view',compact('view'));
    }

    public function delete($id){
        $userId = Crypt::decrypt($id);
        $delete = BankName::where('id',$userId)->first();
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
