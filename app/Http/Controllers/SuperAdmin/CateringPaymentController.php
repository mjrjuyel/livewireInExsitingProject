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

    $runningPaymentAll = CateringPayment::whereMonth('payment_date',date('m'))->whereYear('payment_date',date('Y'))->orderBy('payment_date','ASC')->get();

    // $prePayment = CateringPayment::where('month',date('Y-m',strtotime(' - 1 month')))->latest('id')->first();
    $preTotalCost = CateringFood::whereMonth('order_date','!=',now()->month)->sum('total_cost');
    $preTotalPayment = CateringPayment::whereMonth('payment_date','!=',now()->month)->sum('payment');
    // return $runningPayment;
    return view('superadmin.catering.payment.checkbill',compact(['runningMonth','runningPayment','parseDate','preTotalCost','preTotalPayment','runningPaymentAll']));
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

            // if($previousDay <= $submitDay){
                // $parseDate = Carbon::parse($request['date']);

                // // return $parseDate->day;
                // $checkSameDate = CateringPayment::whereDate('payment_date',$parseDate)->exists();
                // if($checkSameDate){
                //     Session::flash('error','Date is Already Exist');
                //     return redirect()->back();
                // }

                $checkTotalCost = CateringFood::sum('total_cost');
                $checkTotalPayment = CateringPayment::sum('payment');

                $insert= CateringPayment::create([
                'payment_date'=>$request['date'],
                'payment'=>$request['amount'],
                'p_creator'=>Auth::user()->id,
                'created_at'=>Carbon::now(),
                ]);

                if($insert){
                    Session::flash('success','New Payment in Current Month');
                    return redirect()->back();
                }
                
                // Session::flash('error','Date is Too Old For Insert');
                // return redirect()->back();
            // }
        }
        Session::flash('error','Date is Bigger from Present date');
        return redirect()->back();
   
   }

   public function index(){
    $search_date = new DateTime(now());
    $allPayment = CateringPayment::whereYear('payment_date',now()->year)->latest('payment_date')->get();
    $totalPayment =  $allPayment->sum('payment');
    // return $allPayment->sum('payment');
    return view('superadmin.catering.payment.index',compact(['allPayment','totalPayment','search_date']));
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
    public function delete(Request $request){

        $userId = CateringPayment::findOrFail($request->id);
        $userId->delete();
        if($userId){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('success','One Extra Payment Delete!');
        return redirect()->back();
        }
    }

    public function searchMonth($month){
        $search_date = new DateTime($month);

        $parse_search = Carbon::parse($search_date);
        $allPayment =CateringPayment::whereMonth('payment_date',$parse_search->month)->whereYear('payment_date',$parse_search->year)->latest('payment_date')->get();
        $totalPayment =  $allPayment->sum('payment');
        // return $allPayment->sum('payment');
        return view('superadmin.catering.payment.indexMonth',compact(['allPayment','totalPayment','search_date']));
       }
    public function searchYear($year){
        $search_date = new DateTime($year);

        $parseMonth = new DateTime($search_date->format('d-m-Y'));

        $preYear = new DateTime($search_date->format('Y'));
        $preYear->modify('-1 year');
        $nextYear = new DateTime($search_date->format('Y'));
        $nextYear->modify('+1 year');

        return "preyear " . $preYear->format('y') . "Present ". $search_date->format('y') . " ";
        
        $parse_search = Carbon::parse($search_date);
        $allPayment = CateringPayment::whereYear('payment_date',$parse_search->year)->latest('payment_date')->get();
        $totalPayment =  $allPayment->sum('payment');
        // return $search_date->format('Y-m-d');
        return view('superadmin.catering.payment.indexMonth',compact(['allPayment','totalPayment','search_date']));
       }

}
