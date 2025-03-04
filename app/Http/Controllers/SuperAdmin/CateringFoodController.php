<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\CateringFood;
use Carbon\Carbon;
use Session;
use Auth;
use DateTime;
use DateInterval;

class CateringFoodController extends Controller
{

    public function __construct(){
        $this->middleware('permission:Add Meal')->only('add','insert');
        $this->middleware('permission:Edit Meal')->only('edit','update');
        $this->middleware('permission:View Meal')->only('view','index');
        $this->middleware('permission:Delete Meal')->only('delete');
    }
       
    //  All Role 
    public function index(){
        $search_date = new DateTime(now());
        $allFood = CateringFood::whereMonth('order_date',date('m'))->whereYear('order_date',date('Y'))->orderBy('order_date','ASC')->get();
        // return $parseDate;
        return view('superadmin.catering.food.index',compact(['allFood','search_date']));
    }
    // role Add
    public function add(){
        $lastOrder = CateringFood::latest('id')->first();
        // return $lastOrder;
        return view('superadmin.catering.food.add',compact('lastOrder'));
    }
    
    public function insert(Request $request){
        $request->validate([
            'date'=>'required',
            'quantity'=>'required',
            'perCost'=>'required',
        ]);

        $presentDay = strtotime('now');
        $submitDay = strtotime($request->date);
        
        // If input date is over form present date
        if($presentDay >= $submitDay){

                $parseDate = Carbon::parse($request['date']);

                // return $parseDate->day;
                $checkSameDate = CateringFood::whereDate('order_date',$parseDate)->exists();
                if($checkSameDate){
                    Session::flash('error','Date is Already Exist');
                    return redirect()->back();
                }

                $insert=CateringFood::create([
                'order_date'=>$request['date'],
                'quantity'=>$request['quantity'],
                'per_cost'=>$request['perCost'],
                'total_cost'=>$request['quantity'] * $request['perCost'],
                'creator'=>Auth::user()->id,
                'created_at'=>Carbon::now(),
            ]);
            if($insert){
                Session::flash('success','Item Added in Catering Food History');
                return redirect()->back();
            }
        }
        Session::flash('error','Date is over from Present date');
        return redirect()->back();

        
    }

    // Role  Update
    public function edit($id){
        $userId = Crypt::decrypt($id);
        $edit = CateringFood::where('id',$userId)->first();
        return view('superadmin.catering.food.edit',compact('edit'));
    }

    public function update(Request $request){

        $id = $request['id'];

        $request->validate([
            'date'=>'required',
            'quantity'=>'required',
            'perCost'=>'required',
        ]);
        
        // return $request->all();
        $update = CateringFood::where('id',$id)->update([
            'order_date'=>Carbon::parse($request['date']),
            'quantity'=>$request['quantity'],
            'per_cost'=>$request['perCost'],
            'total_cost'=>$request['quantity'] * $request['perCost'],
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Updated!');
            return redirect()->back();
        }
    }

    public function view($id){
        $userId = Crypt::decrypt($id);
        $view = CateringFood::where('id',$userId)->first();
        return view('superadmin.catering.food.view',compact('view'));
    }

    public function delete(Request $request){
        $delete = CateringFood::where('id',$request->id)->first();
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('success','Catering Food Item Delete!');
        return redirect()->back();
        }
    }

    public function searchMonth($month){
        $search_date= new DateTime($month);
        // $date = Carbon::parse($month);
        $parseDate = Carbon::parse($search_date);
        $allFood = CateringFood::whereMonth('order_date',$parseDate->month)->whereYear('order_date',$parseDate->year)->get();

        return view('superadmin.catering.food.indexMonth',compact(['allFood','search_date']));
    } 

    public function searchYear($month){
        $search_date= new DateTime($month);
        // $date = Carbon::parse($month);
        $parseDate = Carbon::parse($search_date);
        $allFood = CateringFood::whereYear('order_date',$parseDate->year)->get();

        return view('superadmin.catering.food.indexYear',compact(['allFood','search_date']));
    } 
}
