<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Leave;
// use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeLeaveSetting;
use App\Models\OfficeBranch;
use App\Models\Designation;
use App\Models\BankName;
use App\Models\BankBranch;
use App\Models\Department;
use App\Models\EmployeePromotion;
use App\Models\EmployeeEvaluation;
use App\Models\EarlyLeave;
use Carbon\Carbon;
use DateTime;
use Session;
use Auth;

class AdminEmployeController extends Controller
{

    public function __construct(){
        $this->middleware('permission:All User')->only('index');
        $this->middleware('permission:Add User')->only('add','insert');
        $this->middleware('permission:Edit User')->only('edit','update');
        $this->middleware('permission:View User')->only('view');
        $this->middleware('permission:Soft Delete User')->only('softdele'); 
        $this->middleware('permission:Restore User')->only('restore'); 
        $this->middleware('permission:Delete User')->only('delete');
        $this->middleware('permission:Login Another Profile')->only('login');
    }

    // Fethch All Employer Data
    public function index(){
        $employe = User::with(['reporting:id,name','department:id,depart_name','emp_desig:id,title','bankName:id,bank_name','bankBranch:id,bank_branch_name','officeBranch:id,branch_name','creator:id,name','editor:id,name'])->where('status','!=',0)->latest('id')->get();
        // return $employe;
        return view('superadmin.employe.index',compact('employe'));
    }
    // Add Employe 
    public function add(){
        $roles = Role::orderBy('id')->get(['id','name']);
        $department = Department::get(['id','depart_name']);
        $designation= Designation::get(['id','title']);
        $report = User::where('status',1)->get();
        $officeBranch = OfficeBranch::get(['id','branch_name']);
        $bankName = BankName::get(['id','bank_name']);
        $bankBranch = BankBranch::get(['id','bank_branch_name']);
        // return $roles;
        return view('superadmin.employe.add',compact(['roles','designation','report','officeBranch','bankName','bankBranch','department']));
    }
    public function insert(Request $request){
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'pic'=>' max:512 | image | mimes:jpeg,jpg,png',
            'email'=>'required | email:rfc,dns | unique:users,email',
            'phone'=>'required',
            'gender'=>'required',
            'marriage'=>'required',
            'dob'=>'required',
            'emerPhone'=>'required',
            'emerName'=>'required | max:50',
            'emerRelation'=>'required',
            'add'=>'required',
            'sameAdd'=>'required',
            // 'preAdd'=>'required',
            'department'=>'required',
            'desig'=>'required',
            'empType'=>'required',
            'join'=>'required',
            // 'reporting'=>'required',
            'id_type'=>'required',
            'id_number'=>'unique:users,id_number',
            'degre'=>'required',
            'degreYear'=>'required',
            'bankName'=>'required',
            'accountNumber'=>'required',
            'accountName'=>'required',
            'OffBranch'=>'required',
            'signature'=>' max:300 | image | mimes:jpeg,jpg,png',
            'role'=>'required',
            'pass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()
            ->numbers()
            ->symbols()],
            'repass' => 'required | same:pass',
            
        ]);

        if($request->hasFile('pic')){
            $imageTake = $request->file('pic');
            $image_name = 'emp-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/employe/profile/'.$image_name);
        }
        if($request->hasFile('signature')){
            $imageTake = $request->file('signature');
            $image_signa = 'signa-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/employe/profile/'.$image_signa);
        }

        if(empty($request->eva_end_date)){
            // return $request->join_date;
            $endDate = new DateTime($request->join_date);
            $endDate->modify('+1 year');

            // return $endDate->format('Y-m-d');
        }
   
        $insert = User::create([
            'name'=>$request['name'],
            'dob'=>$request['dob'],
            'email'=>$request['email'],
            'email2'=>$request['email2'],
            'phone'=>$request['phone'],
            'phone2'=>$request['phone2'],
            'address'=>$request['add'],
            'present'=>$request->sameAdd == 1 ? $request->add : $request->preAdd,
            'gender'=>$request['gender'],
            'marriage'=>$request['marriage'],
            'emer_contact'=>$request['emerPhone'],
            'emer_name'=>$request['emerName'],
            'emer_relation'=>$request['emerRelation'],
            'report_manager'=>$request['reporting'],
            'depart_id'=>$request['department'],
            'desig_id'=>$request['desig'],
            'emp_type'=>$request['empType'],

            // identity verification
            'id_type'=>$request['id_type'],
            'id_number'=>$request['id_number'],

            'rec_degree'=>$request['degre'],
            'rec_year'=>$request['degreYear'],

            'bank_id'=>$request['bankName'],
            'bank_branch_id'=>$request['bankBranch'],
            'bank_account_name'=>$request['accountName'],
            'bank_account_number'=>$request['accountNumber'],
            'bank_sort_code'=>$request['sortCode'],
            'bank_swift_code'=>$request['swiftCode'],
            // 'bank_routing_number'=>$request['add'],
            // 'bank_country'=>$request['add'],

            'office_branch_id'=>$request['OffBranch'],
            'office_id_number'=>rand(10000,99999),
            'office_card_number'=>$request['accessCard'],
            'office_IT_requirement'=>$request['system'],
            'office_work_schedule'=>$request['schedule'],

            
            'signature'=>$image_signa ?? null,
            
            'image'=>$image_name ?? null,
            'join_date'=>$request['join'],
            'password'=>Hash::make($request['pass']),
            'creator'=>Auth::user()->id,
            'created_at'=>Carbon::now('UTC'),
        ]);

        $insert->syncRoles($request->role);
      
            // Evaluation Create
            $evaluation = EmployeeEvaluation::create([
                'emp_id' =>$insert->id,
                'eva_last_date'=>$request->eva_start_date != null ? $request->eva_start_date : $request->join_date,
                'eva_next_date'=>$request->eva_end_date != null ? $request->eva_end_date : $endDate,
                'evaluated_by'=>Auth::user()->id,
                'created_at'=>Carbon::now('UTC')
            ]);

            if($insert){
                Session::flash('success','New Employee Add ');
                return redirect()->route('portal.employe.add');
            }
    }
    
    // view for employe Dashboard
    public function view($slug){

        $userId = Crypt::decrypt($slug);

        $defaultLeave = EmployeLeaveSetting::first();
        $view = User::with(['reporting:id,name','department:id,depart_name','emp_desig:id,title','bankName:id,bank_name','bankBranch:id,bank_branch_name','officeBranch:id,branch_name','creator:id,name','editor:id,name'])->where('id',$userId)->first();

        $whole_approved_leave = Leave::where('emp_id',$view->id)->where('status',2)->latest('id')->sum('total_leave_this_month');
        $leaveRequestInMonth = Leave::where('emp_id',$view->id)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
        $leaveRequestInYear = Leave::where('emp_id',$view->id)->whereYear('start_date',date('Y'))->count();

        $paidRemainingMonth = Leave::where('emp_id',$view->id)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_paid');
        $paidRemainingYear = Leave::where('emp_id',$view->id)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_paid');

        $unpaidRemainingMonth = Leave::where('emp_id',$view->id)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_unpaid');
        
        $unpaidRemainingYear = Leave::where('emp_id',$view->id)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_unpaid');
         //previous month 
         $unpaidPreviousMonth = Leave::where('emp_id', $view->id)->where('status', 2)->whereMonth('start_date', now()->subMonth()->month)->whereYear('start_date', now('Y'))->sum('total_unpaid'); 
        // Evalution Data 
        $EmpEva = EmployeeEvaluation::where('emp_id',$view->id)->latest('renewed_at')->first();

         //Evaluation date Calculation
         if($EmpEva == null || $EmpEva->eva_next_date == ' '){
            // return 'No Eva Date';
            $end_date = new DateTime($view->join_date->format('Y-m-d'));
            $end_date->modify('+1 year');

            $start_date = new DateTime($view->join_date->format('Y-m-d'));

            $formatted_start_date = $start_date->format('Y-m-d');
            $formatted_end_date = $end_date->format('Y-m-d');
        
            // Leave calculation (Paid/Unpaid)
            $Evaleaves = Leave::where('emp_id', $view->id)->where('status',2)
            ->where(function ($query) use ($formatted_start_date, $formatted_end_date) {
                $query->whereBetween('start_date', [$formatted_start_date, $formatted_end_date])
                      ->whereBetween('end_date', [$formatted_start_date, $formatted_end_date]);
            })->get();
            }
            else{
                
                $Evaleaves = Leave::where('emp_id', $view->id)
                ->where('status', 2)
                ->where(function ($query) use ($EmpEva) {
                    $query->whereBetween('start_date', [$EmpEva->eva_last_date, $EmpEva->eva_next_date])
                          ->whereBetween('end_date', [$EmpEva->eva_last_date , $EmpEva->eva_next_date]);
                })
                ->get();
            }

            // All Designation and Department
            $departs = Department::all();
            $designs = Designation::all();
            $activeDesig = EmployeePromotion::where('emp_id',$view->id)->latest('id')->first();
            
            $earlyleave = EarlyLeave::where('status',2)->where('emp_id',$view->id)->whereMonth('leave_date',date('m'))->whereYear('leave_date',date('Y'))->sum('total_hour');
           
            $earlyleaveYear = EarlyLeave::where('status',2)->where('emp_id',$view->id)->whereYear('leave_date',date('Y'))->sum('total_hour');
            $previousMonthEarlyLeave = EarlyLeave::where('status',2)->where('emp_id',$view->id)->whereMonth('leave_date',now()->subMonth()->month)->whereYear('leave_date',date('Y'))->sum('total_hour');
            // Employee Evalaution Data 
            // return $unpaidPreviousMonth;
         return view('superadmin.employe.view',compact(['view','leaveRequestInMonth','leaveRequestInYear','paidRemainingMonth','whole_approved_leave','paidRemainingYear','defaultLeave','unpaidRemainingMonth','unpaidRemainingYear','Evaleaves','departs','designs','activeDesig','EmpEva','earlyleave','earlyleaveYear','unpaidPreviousMonth','previousMonthEarlyLeave']));
    }

    // Edit Admin
    public function edit($slug){
        $userId = Crypt::decrypt($slug);
        $roles = Role::orderBy('id')->get(['id','name']);
        $ModelRoles= DB::table('model_has_roles')->where('model_id',$userId)->pluck('role_id')->all();
        $designation= Designation::all();
        $report = User::where('status',1)->get();
        $officeBranch = OfficeBranch::all();
        $bankName = BankName::all();
        $bankBranch = BankBranch::all();
        $department = Department::all();
        $edit = User::where('id',$userId)->first();
    
        // return $edit;
        return view('superadmin.employe.edit',compact(['edit','roles','ModelRoles','designation','report','officeBranch','bankName','bankBranch','department']));
    }

    public function update(Request $request){

        $id = $request['id'];
        // get Associted Admin User
        $employe = User::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'pic' => 'max:512 | image | mimes:jpeg,jpg,png',
            'role'=>'required',
            'email'=>'required | email:rfc,dns | unique:users,email,'.$id,
            'phone'=>'required',
            'gender'=>'required',
            'marriage'=>'required',
            'dob'=>'required',
            'emerPhone'=>'required',
            'emerName'=>'required | max:50',
            'emerRelation'=>'required',
            'add'=>'required',
            // 'sameAdd'=>'required',
            'preAdd'=>'required',
            'desig'=>'required',
            'empType'=>'required',
            'join'=>'required',
            // 'eva_start_date'=>'required',
            // 'eva_end_date'=>'required',
            'reporting'=>'required',
            'id_type'=>'required',
            'id_number'=>'unique:users,id_number,'.$id,
            'degre'=>'required',
            'degreYear'=>'required',
            'bankName'=>'required',
            'accountNumber'=>'required | unique:users,bank_account_number,'.$id,
            'accountName'=>'required',
            'OffBranch'=>'required',
        ]);

        if($request->pass != ''){
            $request->validate([
                'pass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()
                ->numbers()
                ->symbols()],
                'repass' => 'required | same:pass',
            ]);
            User::where('id',$id)->update([
                'password'=>Hash::make($request['pass']),
            ]);
        }

        $old= User::find($id);
        $path = public_path('uploads/employe/profile/');

        if($request->hasFile('pic')){

            if($old->image !='' && $old->image != null){
                $old_pic = $path.$old->image;
                unlink($old_pic);
            }

            $imageTake = $request->file('pic');
            $image_name = 'emp-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/employe/profile/'.$image_name);

            User::where('id',$id)->update([
                'image'=>$image_name,
            ]);
        }

        if($request->hasFile('signature')){

            if($old->signature !='' && $old->signature != null){
                $old_pic = $path.$old->signature;
                unlink($old_pic);
            }

            $imageTake = $request->file('signature');
            $image_signa = 'signa-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/employe/profile/'.$image_signa);

            User::where('id',$id)->update([
                'signature'=>$image_signa,
            ]);
        }
        
        $update = User::where('id',$id)->update([
            'name'=>$request['name'],
            'dob'=>$request['dob'],
            'email'=>$request['email'],
            'email2'=>$request['email2'],
            'phone'=>$request['phone'],
            'phone2'=>$request['phone2'],
            'address'=>$request['add'],
            'present'=>$request['preAdd'],
            'gender'=>$request['gender'],
            'marriage'=>$request['marriage'],
            'emer_contact'=>$request['emerPhone'],
            'emer_name'=>$request['emerName'],
            'emer_relation'=>$request['emerRelation'],
            'report_manager'=>$request['reporting'],
            'depart_id'=>$request['department'],
            'desig_id'=>$request['desig'],
            'emp_type'=>$request['empType'],

            // identity verification
            'id_type'=>$request['id_type'],
            'id_number'=>$request['id_number'],

            'rec_degree'=>$request['degre'],
            'rec_year'=>$request['degreYear'],

            'bank_id'=>$request['bankName'],
            'bank_branch_id'=>$request['bankBranch'],
            'bank_account_name'=>$request['accountName'],
            'bank_account_number'=>$request['accountNumber'],
            'bank_sort_code'=>$request['sortCode'],
            'bank_swift_code'=>$request['swiftCode'],
            // 'bank_routing_number'=>$request['add'],
            // 'bank_country'=>$request['add'],

            'office_branch_id'=>$request['OffBranch'],
            'office_id_number'=>rand(10000,99999),
            'office_card_number'=>$request['accessCard'],
            'office_IT_requirement'=>$request['system'],
            'office_work_schedule'=>$request['schedule'],

            'join_date'=>$request['join'],

            'resign_date'=>$request->resign,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        $employe = User::findOrFail($id);

        $employe->syncRoles($request->role);

        if($update){
            if(!empty($request->resign)){
                    User::where('id',$id)->update([
                        'status'=>3
                    ]);
                Session::flash('success','Employee Have Resigned !');
                return redirect()->back();
            }
            elseif(empty($request->resign)){
                User::where('id',$id)->update([
                    'status'=>1
                ]);
            Session::flash('success','Update Employe Info');
            return redirect()->back();
        }
            Session::flash('success','Update Employe Details ');
            return redirect()->back();
        }
    }
    // Softy Delete 
    public function softdele(Request $request){
        $id = $request['id'];
        $softdel = User::where('id',$id)->update([
            'status'=>0,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($softdel){
            Session::flash('success','Employe is Deactivated!');
            return redirect()->back();
        }
    }

    public function restore(Request $request){
        $id = $request['id'];

        $softdel = User::where('id',$id)->update([
            'status'=>1,
            'editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($softdel){
            Session::flash('success','Employe is Deactivated!');
            return redirect()->back();
        }
    }
    
    public function delete(Request $request){

        $id = $request['id'];


        $delete = User::where('id',$id)->first();
        $delete->delete();
        if($delete){

        Session::flash('success','Employee Delete!');
        return redirect()->back();
        }
    }

    // View Logged User His Profile.
    public function profileView($slug){
        $userId = Crypt::decrypt($slug);
        $view = User::with(['reporting:id,name','department:id,depart_name','emp_desig:id,title','bankName:id,bank_name','bankBranch:id,bank_branch_name','officeBranch:id,branch_name','creator:id,name','editor:id,name'])->where('id',$userId)->first();
        $activeDesig = EmployeePromotion::where('emp_id',$view->id)->latest('pro_date')->first();
        // Evalution Data 
        // return $view;
        $EmpEva = EmployeeEvaluation::where('emp_id',$view->id)->latest('renewed_at')->first();
        return view('superadmin.employe.profile',compact(['view','activeDesig','EmpEva']));
    }

    // update User Own Profile
    public function profileEdit($slug){
        $userId = Crypt::decrypt($slug);
        $edit = User::with(['reporting:id,name','department:id,depart_name','emp_desig:id,title','bankName:id,bank_name','bankBranch:id,bank_branch_name','officeBranch:id,branch_name','creator:id,name','editor:id,name'])->where('id',$userId)->first();
        $designation= Designation::all();

        return view('superadmin.employe.profileEdit',compact(['edit','designation']));
    }

    public function profileUpdate(Request $request){

        $id = $request['id'];
        $request->validate([
            'name'=>'required',
            'pic' => 'max:512 | image | mimes:jpeg,jpg,png',
            'add' => 'required',
            'emerPhone' => 'required',
            'emerName' => 'required',
            'emerRelation' => 'required',
            'email'=>'required | email:rfc,dns | unique:users,email,'.$id,
        ]);

        if($request->oldpass != ''){
            if($request->oldpass){
               $request->validate([
                   'oldpass' => 'required',
                   'newpass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()->numbers()],
               ]);
              
               if (!Hash::check($request->oldpass,auth()->user()->password)) {
                
                   return back()->withErrors(['oldpass' => 'Incorrect current password.']);
               }

                User::where('id',$id)->update([
                    'password'=> Hash::make($request->newpass),
                ]);
           }
       }

        $date = strtotime($request['join']);

        // image Change
        $old= User::find($id);
        $path = public_path('uploads/employe/profile/');
        if($request->hasFile('pic')){

            if($old->image !='' && $old->image != null){
                $old_pic = $path.$old->image;
                unlink($old_pic);
            }

            $imageTake = $request->file('pic');
            $image_name = 'emp-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/employe/profile/'.$image_name);

            User::where('id',$id)->update([
                'image'=>$image_name,
            ]);
        }

        $insert = User::where('id',$id)->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'email2'=>$request['email2'],
            'phone'=>$request['phone'],
            'phone2'=>$request['phone2'],
            'address'=>$request['add'],
            'present'=>$request['preAdd'],
            'emer_contact'=>$request['emerPhone'],
            'emer_name'=>$request['emerName'],
            'emer_relation'=>$request['emerRelation'],
            'desig_id'=>$request['desig'],
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($insert){
            Session::flash('success','Update Profile SuccessFully ');
            return redirect()->route('portal.employe.editprofile',Crypt::encrypt($id));
        }
    }

    public function login($id)
    {
        $employe = User::findOrFail(($id));
        auth()->login($employe, true);
        return redirect()->route('portal');
    }
}