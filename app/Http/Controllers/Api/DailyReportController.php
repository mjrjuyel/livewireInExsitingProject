<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\DailyReportMail;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Employee;
use App\Models\DailyReport;
use App\Models\AdminEmail;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;

class DailyReportController extends Controller
{
    public function index(){
        try{
            // dd('hello');
            $id = auth()->user()->id;
            $alldata = DailyReport::with('employe:id,name')->where('status',1)->where('submit_by',$id)->latest('id')->paginate(10);

            // nurul vai
            if (!$alldata) {
                return response()->json([
                    'success' => false,
                    'message' => 'Daily Report not Fund',
                    'data' => null
                ]);
            }
     
            
            $mappedData = $alldata->getCollection()->map(function ($alldata) {
                return [
                    'id' => $alldata->id,
                    'submit_by' => $alldata->submit_by,
                    'detail'=>$alldata->detail,
                    'check_in'=>$alldata->check_in,
                    'check_out'=>$alldata->check_out,
                    'editor'=>$alldata->editor,
                    'status' => $alldata->status,
                    'created_at' => $alldata->created_at,
                    'updated_at' => $alldata->updated_at,
                ];
            });

            $response = [
                'success' => true,
                'message' => 'All Daily Report Fetch own by Logged Employee',
                'data' => $mappedData,
                'pagination' => [
                    'total' => $alldata->total(),
                    'current_page' => $alldata->currentPage(),
                    'last_page' => $alldata->lastPage(),
                    'per_page' => $alldata->perPage(),
                    'next_page_url' => $alldata->nextPageUrl(),
                    'prev_page_url' => $alldata->previousPageUrl(),
                ],
            ];
            return response()->json($response);
                    // nurul vai
                    // dd($alldata);
                    
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Faild to Fetch Report',
            ],201);
        }
    }

    public function add(){
        $id = auth()->user()->id;
        return view('employe.dailyreport.add');
    }

    public function submit(Request $request){

     try{
        $validate = Validator::make($request->all(),[
            'submit_by'=>'required',
            'submit_date'=>'required',
            'checkin'=>'required',
            'checkout'=>'required',
            'detail'=>'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status'=>true,
                'mesage'=>'Validation Error',
                'Error-message'=>$validate->errors(), 
            ]);
        }
        $id = auth()->user()->id;
        $submitDate = Carbon::parse($request->submit_date);
        $checkDate=DailyReport::where('status',1)->where('submit_by',$id)->whereDay('submit_date',$submitDate->day)->whereMonth('submit_date',$submitDate->month)->count();

        // return $request->all();
        if($checkDate == null || $checkDate == 0){
            // return 'In If Condition';

            $presentDay = strtotime('now');
            $submit = strtotime($request->submit_date);
            // echo  $presentDay;
            if($presentDay >= $submit){
                
                // check 3 Days before in second
                $maximumPreviousDate = strtotime('-3 days',$presentDay);

                if($maximumPreviousDate <= $submit){

                    // return "3 day after";
                    $insert= DailyReport::create([
                        'submit_by'=>$request['submit_by'],
                        'submit_date'=>Carbon::parse($request['submit_date'])->addHours(6),
                        'detail'=>$request['detail'],
                        'check_in'=>Carbon::parse($request->input('checkin'), config('app.timezone'))->setTimezone('UTC')->format('H:i'),
                        'check_out'=>Carbon::parse($request->input('checkout'), config('app.timezone'))->setTimezone('UTC')->format('H:i'),
                        // 'slug'=>'report-'.uniqId(),
                        'created_at'=>Carbon::now('UTC'),
                    ]);
                    $data = DailyReport::where('submit_by',$request['submit_by'])->latest()->first();
                    if($insert){
                        //dd($insert);
                        Session::flash('success','Daily Report Submited');
                        return response()->json([
                            'status'=>true,
                            'message'=>'Report Submit Success Fully',
                            'Data'=>$data,
                        ],200);
                    }
                }else{
                
                    Session::flash('error','You can not Submit report 3 Days before From Current Day!');
                    return response()->json([
                        'status'=>false,
                        'message'=>'You can not Submit report 3 Days before From Current Day!'
                    ],201);
                }
                
            }else{
                Session::flash('error','The Date is not come yet!');
                return response()->json([
                    'status'=>false,
                    'message'=>'The Date is not come yet!',
                ],201);
            }
        }else{
            // return "Else";
            Session::flash('error','Already You have Submitted on This day!');
            return response()->json([
                'status'=>false,
                'message'=>'Already You have Submitted on This day!',
            ],200);
        }
     }catch(Exception $e){
        return response()->json([
            'status'=>false,
            'message'=>'failed to Insert',
            'data'=>$e->getMessage(),
        ],201);
     }
        
    }

    public function edit($slug){
        $edit = DailyReport::where('slug',$slug)->first();
        return view('employe.dailyreport.edit',compact('edit'));
    }

    public function update(Request $request){
        try{
         $report = DailyReport::find($request->id);
            if(!$report){
                return response()->json([
                    'status'=>true,
                    'message'=>"Error MESSAGE",
                    'Data'=>"Data is Not Found",
                ],201);
            }

            $validate = Validator::make($request->all(),[
                'checkin'=>'required',
                'checkout'=>'required',
                'detail'=>'required',
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status'=>true,
                    'mesage'=>'Validation Error',
                    'Error-message'=>$validate->errors(), 
                ],201);
            }
        $report->check_in = Carbon::parse($request->input('checkin'), config('app.timezone'))->setTimezone('UTC')->format('H:i');
        $report->check_out = Carbon::parse($request->input('checkout'), config('app.timezone'))->setTimezone('UTC')->format('H:i');
        $report->detail = $request['detail'];
        $report->editor = auth()->user()->id;
        $report->updated_at = Carbon::now('UTC');
        $report->save();

        return response()->json([
            'status'=>true,
            'message'=>'Report Update SuccessFully',
            'Data'=>$report,
        ],200);
            
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Report Faild to Update',
                'Data'=>$e->getMessage(),
            ],201);
        }
    }
    
    public function getData(Request $request){
        return response()->json([
            'data'=>$request->all(),
        ]);
    }

    public function view($id){
        try{
            $view = DailyReport::find($id);
            return response()->json([
                'status'=>true,
                'message'=>'Single Daily Report view',
                'data'=>$view,
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Single Daily Report view',
                'data'=>$e->getMessage(),
            ],201);
        }
    }
}
