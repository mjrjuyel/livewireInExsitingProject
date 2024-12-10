<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Employee;
use App\Models\DailyReport;
use Carbon\Carbon;
use Session;

class DailyReportController extends Controller
{
    public function add(){
        return view('employe.dailyreport.add');
    }

    public function submit(Request $request){
        $request->validate([
            'name'=>'required',
            'Submit_date'=>'required',
            'detail'=>'required',
        ]);

        $insert = DailyReport::create([
            'submit_by'=>$request['name'],
            'submit_date'=>Carbon::parse($request['name']),
            'detail'=>$request['detail'],
            'created_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','Succesfully Report Submited!');
            return redirect()->back();
        }
    }
}
