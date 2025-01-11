<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminEmail;
use Carbon\Carbon;
use Session;
use Auth;

class AdminEmailController extends Controller
{
    public function index(){
        $setting = AdminEmail::where('id',1)->first();
        // return $setting;
        return view('superadmin.basic.email.index',compact('setting'));
    }

    public function update(Request $request){

        // return $request->all();
        $request->validate([
            'emailAdd'=>'required',
        ]);

        $update = AdminEmail::where('id',1)->update([
            'email'=>$request['emailAdd'],
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','New Email Change For this Appliaction');
            return redirect()->back();
        }
    }
}
