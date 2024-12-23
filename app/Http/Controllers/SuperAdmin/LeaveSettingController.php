<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeLeaveSetting;
use Carbon\Carbon;
use Session;
use Auth;

class LeaveSettingController extends Controller
{
    public function index(){
        $setting = EmployeLeaveSetting::where('id',1)->first();
        // return $setting;
        
        $explode = explode(',',$setting->specialoffday);

        usort($explode,function($a,$b){
            return strtotime($a) - strtotime($b);
        });

        $groupByMonth = [];
        foreach($explode as $dates){
            $month = date('F',strtotime($dates));
            $groupByMonth[$month][]=$dates;
        }
       
        
        return view('superadmin.basic.leaveSetting.index',compact(['setting','groupByMonth']));
    }

    public function update(Request $request){

        // return $request->all();
        $request->validate([
            'year'=>'required',
            'month'=>'required',
            'weekoff'=>'required',
            'specialoff'=>'required',
        ]);

        $update = EmployeLeaveSetting::where('id',1)->update([
            'year_limit'=>$request['year'],
            'month_limit'=>$request['month'],
            'weekoffday'=>$request['weekoff'],
            'specialoffday'=>$request['specialoff'],
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Leave Setting updated!');
            return redirect()->back();
        }
    }
}
