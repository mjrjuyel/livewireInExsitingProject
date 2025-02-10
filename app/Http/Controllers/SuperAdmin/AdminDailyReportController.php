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
        $this->middleware('permission:View Daily-Report')->only('view','index','searchName');
        $this->middleware('permission:Soft Delete Daily-Report')->only('softDelete');
        $this->middleware('permission:Restore Daily-Report')->only('restore');
        $this->middleware('permission:Delete Daily-Report')->only('delete');
    }

    public function index(){
        $alldata = DailyReport::with('employe')->where('status',1)->orderBy('created_at','DESC')->get();
        $name = DailyReport::with('employe')->distinct()->get('submit_by');
        $dates = DailyReport::selectRaw('YEAR(submit_date) as year')->distinct()->orderBy('year', 'ASC')->pluck('year');
        // return $dates;
        // return $alldata;
        return view('superadmin.dailyreport.index',compact(['alldata','name','dates']));
    }

    public function view($slug){
        $view = DailyReport::with(['employe','report_editor'])->where('slug',$slug)->latest('id')->first();
        // return $view;
        return view('superadmin.dailyreport.view',compact('view'));
    }

    //Search By Name
    
    public function searchName($name){
        $alldata = DailyReport::where('submit_by',$name)->orderBy('submit_date','DESC')->get();
            $html = '';
                foreach ($alldata as $data) {
                    $html .= '<tr>
                                <td>' . htmlspecialchars($data->employe->emp_name) . '</td>
                                <td>' . $data->submit_date->format('d-M-Y') . '</td>
                                <td>' . formatDate($data->created_at) . '</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                
                    // Check if the user has "View Daily-Report" permission
                    if (auth()->user()->can('View Daily-Report')) {
                        $html .= '<li><a class="dropdown-item" href="' . url('superadmin/dailyreport/view/'.$data->slug) . '"><i class="mdi mdi-eye-circle-outline"></i> View</a></li>';
                    }
                
                    // Check if the user has "Soft Delete Daily-Report" permission
                    if (auth()->user()->can('Soft Delete Daily-Report')) {
                        $html .= '<li><a href="#" id="softDel" class="dropdown-item waves-effect waves-light text-danger" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#softDelete"><i class="mdi mdi-delete-alert"></i> Delete</a></li>';
                    }
                
                    $html .= '</ul>
                                    </div>
                                </td>
                            </tr>';
                    }
                    return response()->json(['html'=> $html]);
    }

    public function searchYear($year){
        $alldata = DailyReport::whereYear('submit_date',$year)->get();
        $html = '';
        foreach ($alldata as $data) {
            $html .= '<tr>
                        <td>' . $data->employe->emp_name . '</td>
                        <td>' . $data->submit_date->format('d-M-Y') . '</td>
                        <td>' . formatDate($data->created_at) . '</td>
                    </tr>';
        }
        return response()->json($html);
    }
    public function searchMonth($month){
        $alldata = DailyReport::whereMonth('submit_date',$month)->get();
        $html = '';
        foreach ($alldata as $data) {
            $html .= '<tr>
                        <td>' . $data->employe->emp_name . '</td>
                        <td>' . $data->submit_date->format('d-M-Y') . '</td>
                        <td>' . formatDate($data->created_at) . '</td>
                    </tr>';
        }
        return response()->json($html);
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
