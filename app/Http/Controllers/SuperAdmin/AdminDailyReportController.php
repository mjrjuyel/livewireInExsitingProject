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
    public function __construct(){
        $this->middleware('permission:Add Daily-Report')->only('add','insert');
        $this->middleware('permission:Edit Daily-Report')->only('edit','update');
        $this->middleware('permission:View Daily-Report')->only('view');
        $this->middleware('permission:Soft Delete Daily-Report')->only('softDelete');
        $this->middleware('permission:Restore Daily-Report')->only('restore');
        $this->middleware('permission:Delete Daily-Report')->only('delete');
    }

    public function index(){
        $alldata = DailyReport::with('employe')->where('status',1)->orderBy('created_at','DESC')->get();
        $name = DailyReport::with('employe')->distinct()->get('submit_by');
        // return $alldata;
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
        $alldata = DailyReport::where('submit_by',$id)->where('status',1)->orderBy('created_at','DESC')->get();

        $name = DailyReport::with('employe')->distinct()->get('submit_by');
        // return $recentName;
        return view('superadmin.dailyreport.searchname',compact(['alldata','name','recentName']));
    }

    // soft Delete
    public function softDelete(Request $request){
        $slug = $request['id'];
        $softdelete = DailyReport::where('status',1)->where('id',$slug)->update([
            'status'=>0,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);
        if($softdelete){
            Session::flash('error','Moved Into Trash !');
            return redirect()->back();
        }
    }

    public function restore(Request $request){
        $id = $request['id'];

        $store = DailyReport::where('id',$id)->update([
            'status'=>1,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($store){
            Session::flash('success','Daily Report Restore!');
            return redirect()->back();
        }
    }
    
    public function delete(Request $request){

        $id = $request['id'];

        $delete = DailyReport::where('id',$id)->first();
        $delete->delete();
        if($delete){

        Session::flash('success','Daily Report Deleted!');
        return redirect()->back();
        }
    }
}
