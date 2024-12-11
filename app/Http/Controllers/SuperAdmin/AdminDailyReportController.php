<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Employee;
use App\Models\DailyReport;
use Carbon\Carbon;
use Session;
use Auth;

class AdminDailyReportController extends Controller
{
    public function index(){
        $alldata = DailyReport::with('employe')->where('status',1)->latest('id')->get();
        // return $alldata;
        return view('superadmin.dailyreport.index',compact('alldata'));
    }

    public function view($slug){
        $view = DailyReport::with('employe')->where('slug',$slug)->latest('id')->first();

        return view('superadmin.dailyreport.view',compact('view'));
    }

    // soft Delete
    public function softDelete(Request $request){
        $slug = $request['slug'];

        $softdelete = DailyReport::where('status',1)->where('slug',$slug)->update([
            'status'=>0,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($softdelete){
            Session::flash('error','Moved Into Trash !');
            return redirect()->back();
        }
    }
}
