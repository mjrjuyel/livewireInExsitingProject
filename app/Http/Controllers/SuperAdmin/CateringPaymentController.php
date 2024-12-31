<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\CateringPayment;
use App\Models\CateringFood;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use Session;
use Auth;

class CateringPaymentController extends Controller
{

    // check Invoice for payment
   public function checkBill(){
    $parseDate = Carbon::parse(strtotime('now'));
    // return $parseDate;
    $previosMonth = date('Y-m', strtotime('- 1 month'));
    // return $previosMonth;
    $runningMonth = CateringFood::whereMonth('order_date',date('m'))->whereYear('order_date',date('Y'))->orderBy('order_date','ASC')->get();
    $runningPayment = CateringPayment::whereMonth('payment_date',date('m'))->whereYear('payment_date',date('Y'))->sum('payment');

    // $prePayment = CateringPayment::where('month',date('Y-m',strtotime(' - 1 month')))->latest('id')->first();
    $preTotalCost = CateringFood::whereMonth('order_date','!=',now()->month)->sum('total_cost');
    $preTotalPayment = CateringPayment::whereMonth('payment_date','!=',now()->month)->sum('payment');
    // return $runningPayment;
    return view('superadmin.catering.payment.checkbill',compact(['runningMonth','runningPayment','parseDate','preTotalCost','preTotalPayment']));
   }

   // Payment Insert
   public function add(){
    $checkTotalCost = CateringFood::sum('total_cost');
    $checkTotalPayment = CateringPayment::sum('payment');

    $totalDue = $checkTotalCost-$checkTotalPayment;
    return view('superadmin.catering.payment.add',compact('totalDue'));
   }

   public function insert(Request $request){
    $request->validate([
        'date'=>'required',
        'amount'=>'required',
    ]);

    $presentDay = strtotime('now');
    $submitDay = strtotime($request->date);
    
    // If input date is over form present date
    if($presentDay >= $submitDay){
         $previousDay = strtotime('-10 days',$presentDay);

         if($previousDay <= $submitDay){
            $parseDate = Carbon::parse($request['date']);

            // return $parseDate->day;
            $checkSameDate = CateringPayment::whereDate('payment_date',$parseDate)->exists();
            if($checkSameDate){
                Session::flash('error','Date is Already Exist');
                return redirect()->back();
            }

            $checkTotalCost = CateringFood::sum('total_cost');
            $checkTotalPayment = CateringPayment::sum('payment');

            if($checkTotalCost < $checkTotalPayment + $request['amount']){
                // return "its Hight";
                Session::flash('over','Your payment Is high Than Total Due');
                $insert=CateringPayment::create([
                    'payment_date'=>$request['date'],
                    'payment'=>$request['amount'],
                    'p_creator'=>Auth::user()->id,
                    'created_at'=>Carbon::now(),
                ]);
                
                return redirect()->back();

            }
            $insert=CateringPayment::create([
            'payment_date'=>$request['date'],
            'payment'=>$request['amount'],
            'p_creator'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
        ]);
        if($insert){
            Session::flash('success','New Payment in Current Month');
            return redirect()->back();
        }
         }
         Session::flash('error','Date is Too Old For Insert');
         return redirect()->back();
    }
    Session::flash('error','Date is over from Present date');
    return redirect()->back();

    
   }

   public function index(){
    $allPayment = CateringPayment::whereYear('payment_date',now()->year)->latest('payment_date')->get();
    $totalPayment =  $allPayment->sum('payment');
    // return $allPayment->sum('payment');
    return view('superadmin.catering.payment.index',compact(['allPayment','totalPayment']));
   }

   public function view($id){
    $userId = Crypt::decrypt($id);
    $view = CateringPayment::where('id',$userId)->first();
    return view('superadmin.catering.payment.view',compact('view'));
}

   public function edit($slug){
    $Id = Crypt::decrypt($slug);

    $checkTotalCost = CateringFood::sum('total_cost');
    $checkTotalPayment = CateringPayment::sum('payment');
    $totalDue = $checkTotalCost-$checkTotalPayment;

    // return $Id;
    $edit = CateringPayment::where('id',$Id)->first();
    return view('superadmin.catering.payment.edit',compact(['edit','totalDue']));
   }

   public function update(Request $request){
    $id = $request['id'];

    $request->validate([
        'date'=>'required',
        'amount'=>'required',
    ]);

    $presentDay = strtotime('now');
    $submitDay = strtotime($request->date);
    
    // If input date is over form present date
    if($presentDay >= $submitDay){
         $previousDay = strtotime('-10 days',$presentDay);

         if($previousDay <= $submitDay){
            $parseDate = Carbon::parse($request['date']);

            $checkTotalCost = CateringFood::sum('total_cost');
            $checkTotalPayment = CateringPayment::sum('payment');

            // if($checkTotalCost < $checkTotalPayment + $request['amount']){
            //     // return "its Hight";
            //     Session::flash('error','Your payment Is high Than Total Due');
            //     return redirect()->back();
            // }
            
            $insert=CateringPayment::where('id',$id)->update([
            'payment_date'=>$request['date'],
            'payment'=>$request['amount'],
            'p_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);
        if($insert){
            Session::flash('success','Update Payment Details');
            return redirect()->back();
        }
         }
         Session::flash('error','Date is Too Old For Insert');
         return redirect()->back();
    }
    Session::flash('error','Date is over from Present date');
    return redirect()->back();

   }

//    delete
    public function delete($id){
        $userId = Crypt::decrypt($id);
        $delete = CateringPayment::where('id',$userId)->first();
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('error','One Extra Payment Delete!');
        return redirect()->back();
        }
}

}
