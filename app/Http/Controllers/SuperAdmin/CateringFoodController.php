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
       
    //  All Role 
    public function index(){
        $allFood = CateringFood::whereMonth('order_date',date('m'))->whereYear('order_date',date('Y'))->orderBy('order_date','ASC')->get();
        // return $allFood->sum('total_cost');
        return view('superadmin.catering.food.index',compact('allFood'));
    }
    // role Add
    public function add(){
        return view('superadmin.catering.food.add');
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
             $previousDay = strtotime('-10 days',$presentDay);

             if($previousDay <= $submitDay){
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
                Session::flash('success','Item Added in Current Month');
                return redirect()->back();
            }
             }
             Session::flash('error','Date is Too Old For Insert');
             return redirect()->back();
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

    public function delete($id){
        $userId = Crypt::decrypt($id);
        $delete = CateringFood::where('id',$userId)->first();
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('error','One Bank Information Delete From The Application');
        return redirect()->back();
        }
    }

    public function searchMonth($month){

        $search_date= new DateTime($month);
        // $date = Carbon::parse($month);
        
        $parseDate = Carbon::parse($seach_date);
        // return $parseDate->month;
        $allFood = CateringFood::whereMonth('order_date',$parseDate->month)->whereYear('order_date',$parseDate->year)->get();

        return view('superadmin.catering.food.index',compact(['allFood','seach_date']));
    } 
}
