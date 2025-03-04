<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Employee;
use App\Models\DailyReport;
use Carbon\Carbon;
use Session;
use Auth;
use DB;

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
        $id = Crypt::decrypt($slug);
        $view = DailyReport::with(['employe','report_editor'])->where('id',$id)->latest('id')->first();
        // return $view;
        return view('superadmin.dailyreport.view',compact('view'));
    }

    //Search By Name
    public function allSearch($year, $month, $name){

        $year = ($year === 'all') ? null : $year;
        $month = ($month === 'all') ? null : $month;
        $name = ($name === 'all') ? null : $name;

        $query = DailyReport::query();

            if (!is_null($year)) {
                $query->whereYear('submit_date', $year);
            }
            if (!is_null($month)) {
                $query->whereMonth('submit_date', $month);
            }
            if (!is_null($name)) {
                $query->where('submit_by',$name);
            }

            $alldata = $query->orderBy('submit_date', 'DESC')->get();

            $html = '';
            foreach ($alldata as $data) {
                $html .= '<tr>
                                <td><input type="checkbox" class="markItem" data-id="'. $data->id .'"></td>
                                <td>' . htmlspecialchars($data->employe->name) . '</td>
                                <td>' . $data->submit_date->format('d-M-Y') . '</td>
                                <td>' . formatDate($data->created_at) . '</td>
                                 <td>' . $data->check_in . "-" .$data->check_out . '</td>
                                <td>' . Str::words($data->detail,15) . '</td>
                               
                                <td>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                
                                    // Check if the user has "View Daily-Report" permission
                                    if (auth()->user()->can('View Daily-Report')) {
                                        $html .= '<li><a class="dropdown-item" href="' . url('portal/dailyreport/view/'.Crypt::encrypt($data->slug)) . '"><i class="mdi mdi-eye-circle-outline"></i> View</a></li>';
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
 
     // Return JSON response with generated HTML
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
