<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Carbon\Carbon;
use Session;
use Auth;

class SuperAdminLeaveController extends Controller
{
    //  All Role 
    public function index(){
        $alldata = Leave::with('admin')->where('status','!=',0)->latest('id')->get();
        // return $alldata;
        return view('superadmin.leave.index',compact('alldata'));
    }

    public function view($slug){
        $view = Leave::with('admin')->where('slug',$slug)->first();
        return view('superadmin.leave.view',compact('view'));
    }

    public function update(Request $request){
        $id = $request['id'];
        $slug = $request['slug'];

        $update = Leave::where('id',$id)->update([
            'status'=>$request['status'],
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Update Leave Form!');
            return redirect()->back();
        }
    }

    public function delete($slug){
        $delete = Leave::where('slug',$slug)->first();
        $delete->delete();
        if($delete){
            $leave = Leave::all();
        // Update the auto-incrementing column values
            foreach ($leave as $index => $row) {
                $row->id = $index + 1;
                $row->save();
            }
        Session::flash('success','Leave Application Delete');
        return redirect()->back();
        }
    }
}
