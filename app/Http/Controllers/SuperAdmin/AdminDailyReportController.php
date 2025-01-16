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
        $alldata = DailyReport::with('employe')->where('status',1)->orderBy('submit_date','DESC')->get();
        $name = DailyReport::with('employe')->distinct()->get('submit_by');
        // return $name;
        return view('superadmin.dailyreport.index',compact(['alldata','name']));
    }

    public function view($slug){
        $view = DailyReport::with(['employe','report_editor'])->where('slug',$slug)->latest('id')->first();
        // return $view;
        return view('superadmin.dailyreport.view',compact('view'));
    }

    //Search By Name
    
    public function searchName(Request $request){
        $id = $request->id;
        $recentName = Employee::where('id',$id)->first();
        $alldata = DailyReport::where('submit_by',$id)->where('status',1)->get();

        $name = DailyReport::with('employe')->distinct()->get('submit_by');
        // return $recentName;
        return view('superadmin.dailyreport.searchname',compact(['alldata','name','recentName']));
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
