<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimeZone;
use Carbon\Carbon;
use Session;
use Auth;

class TimeZoneController extends Controller
{
    public function index(){
        $setting = TimeZone::where('id',1)->first();
        // return $setting;
        return view('superadmin.basic.timezone.index',compact('setting'));
    }

    public function update(Request $request){

        // return $request->all();
        $request->validate([
            'name'=>'required',
        ]);

        $update = TimeZone::where('id',1)->update([
            'name'=>$request['name'],
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Time Zone Change For this Appliaction');
            return redirect()->back();
        }
    }
}
