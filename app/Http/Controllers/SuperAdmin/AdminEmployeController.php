<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\EmployeLeaveSetting;
use App\Models\UserRole;
use App\Models\OfficeBranch;
use App\Models\Designation;
use App\Models\BankName;
use App\Models\BankBranch;
use App\Models\Department;
use Carbon\Carbon;
use Session;
use Auth;

class AdminEmployeController extends Controller
{
    // Add Employe 
    public function add(){
        $role = UserRole::all();
        $designation= Designation::all();
        $report = Employee::where('emp_status',1)->get();
        $officeBranch = OfficeBranch::all();
        $bankName = BankName::all();
        $bankBranch = BankBranch::all();
        $department = Department::all();
    
        // return $bankName;
        return view('superadmin.employe.add',compact(['designation','report','officeBranch','bankName','bankBranch','department']));
    }
    public function insert(Request $request){
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'pic'=>' max:512 | image | mimes:jpeg,jpg,png',
            'email'=>'required | email:rfc,dns | unique:employees,email',
            'phone'=>'required',
            'gender'=>'required',
            'marriage'=>'required',
            'dob'=>'required',
            'emerPhone'=>'required',
            'emerRelation'=>'required',
            'add'=>'required',
            'sameAdd'=>'required',
            // 'preAdd'=>'required',
            'department'=>'required',
            'desig'=>'required',
            'empType'=>'required',
            'join'=>'required',
            'eva_end_date'=>'required',
            'reporting'=>'required',
            'id_type'=>'required',
            'id_number'=>'unique:employees,emp_id_number',
            'degre'=>'required',
            'degreYear'=>'required',
            'bankName'=>'required',
            'accountNumber'=>'required',
            'accountName'=>'required',
            'OffBranch'=>'required',
            'signature'=>' max:300 | image | mimes:jpeg,jpg,png',
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
        
        $insert = Employee::create([
            'emp_name'=>$request['name'],
            'emp_dob'=>$request['dob'],
            'email'=>$request['email'],
            'email2'=>$request['email2'],
            'emp_phone'=>$request['phone'],
            'emp_phone2'=>$request['phone2'],
            'emp_address'=>$request['add'],
            'emp_present'=>$request->sameAdd == 1 ? $request->add : $request->preAdd,
            'gender'=>$request['gender'],
            'marriage'=>$request['marriage'],
            'emp_emer_contact'=>$request['emerPhone'],
            'emp_emer_relation'=>$request['emerRelation'],
            'emp_report_manager'=>$request['reporting'],
            'emp_depart_id'=>$request['department'],
            'emp_desig_id'=>$request['desig'],
            'emp_type'=>$request['empType'],

            // identity verification
            'emp_id_type'=>$request['id_type'],
            'emp_id_number'=>$request['id_number'],

            'emp_rec_degree'=>$request['degre'],
            'emp_rec_year'=>$request['degreYear'],

            'emp_bank_id'=>$request['bankName'],
            'emp_bank_branch_id'=>$request['bankBranch'],
            'emp_bank_account_name'=>$request['accountName'],
            'emp_bank_account_number'=>$request['accountNumber'],
            'emp_bank_sort_code'=>$request['sortCode'],
            'emp_bank_swift_code'=>$request['swiftCode'],
            // 'emp_bank_routing_number'=>$request['add'],
            // 'emp_bank_country'=>$request['add'],

            'emp_office_branch_id'=>$request['OffBranch'],
            'emp_office_id_number'=>rand(10000,99999),
            'emp_office_card_number'=>$request['accessCard'],
            'emp_office_IT_requirement'=>$request['system'],
            'emp_office_work_schedule'=>$request['schedule'],

            
            'emp_signature'=>$image_signa ?? null,
            
            'emp_image'=>$image_name ?? null,

            'emp_slug'=>'emp-'.uniqId(),
            'emp_join'=>$request['join'],
            'eva_start_date'=>$request->eva_start_date != null ? $report->eva_start_date : $request->join,
            'eva_end_date'=>$request->eva_end_date,
            'password'=>Hash::make($request['pass']),
            'emp_creator'=>Auth::user()->id,
            'created_at'=>Carbon::now('UTC'),
        ]);

        if($insert){
            Session::flash('success','New Employee Add ');
            return redirect()->route('superadmin.employe.add');
        }
    }
    
    // Fethch All Employer Data
    public function index(){
        $employe = Employee::with(['emp_role','emp_desig'])->latest('id')->get();
        // return $employe;
        return view('superadmin.employe.index',compact('employe'));
    }


    // view for employe Dashboard
    public function view($slug){
        $defaultLeave = EmployeLeaveSetting::first();
        $view = Employee::with(['emp_role','emp_desig','creator'])->where('emp_slug',$slug)->first();

        $activeEmploye = Employee::where('emp_status',1)->count();

        $whole_approved_leave = Leave::where('emp_id',$view->id)->where('status',2)->latest('id')->sum('total_leave_this_month');
        $leaveRequestInMonth = Leave::where('emp_id',$view->id)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
        $leaveRequestInYear = Leave::where('emp_id',$view->id)->whereYear('start_date',date('Y'))->count();

        $paidRemainingMonth = Leave::where('emp_id',$view->id)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_paid');
        $paidRemainingYear = Leave::where('emp_id',$view->id)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_paid');

        $unpaidRemainingMonth = Leave::where('emp_id',$view->id)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_unpaid');
        $unpaidRemainingYear = Leave::where('emp_id',$view->id)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_unpaid');

        // return $view;
        return view('superadmin.employe.view',compact(['view','activeEmploye','leaveRequestInMonth','leaveRequestInYear','paidRemainingMonth','whole_approved_leave','paidRemainingYear','defaultLeave','unpaidRemainingMonth','unpaidRemainingYear']));
    }

    // Edit Admin
    public function edit($slug){
        $role = UserRole::all();
        $designation= Designation::all();
        $report = Employee::where('emp_status',1)->get();
        $officeBranch = OfficeBranch::all();
        $bankName = BankName::all();
        $bankBranch = BankBranch::all();
        $department = Department::all();
        $edit = Employee::where('emp_slug',$slug)->first();
    
        // return $edit;
        return view('superadmin.employe.edit',compact(['edit','designation','report','officeBranch','bankName','bankBranch','department']));
    }

    public function update(Request $request){

        $id = $request['id'];
        $slug = $request['slug'];
        

        $request->validate([
            'name'=>'required',
            'pic' => 'max:512 | image | mimes:jpeg,jpg,png',
            'email'=>'required | email:rfc,dns | unique:employees,email,'.$id,
            'phone'=>'required',
            'gender'=>'required',
            'marriage'=>'required',
            'dob'=>'required',
            'emerPhone'=>'required',
            'emerRelation'=>'required',
            'add'=>'required',
            // 'sameAdd'=>'required',
            'preAdd'=>'required',
            'desig'=>'required',
            'empType'=>'required',
            'join'=>'required',
            'eva_start_date'=>'required',
            'eva_end_date'=>'required',
            'reporting'=>'required',
            'id_type'=>'required',
            'id_number'=>'unique:employees,emp_id_number,'.$id,
            'degre'=>'required',
            'degreYear'=>'required',
            'bankName'=>'required',
            'accountNumber'=>'required | unique:employees,emp_bank_account_number,'.$id,
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
            Employee::where('id',$id)->update([
                'password'=>Hash::make($request['pass']),
            ]);
        }

        $old= Employee::find($id);
        $path = public_path('uploads/employe/profile/');

        if($request->hasFile('pic')){

            if($old->emp_image !='' && $old->emp_image != null){
                $old_pic = $path.$old->emp_image;
                unlink($old_pic);
            }

            $imageTake = $request->file('pic');
            $image_name = 'emp-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/employe/profile/'.$image_name);

            Employee::where('id',$id)->update([
                'emp_image'=>$image_name,
            ]);
        }

        if($request->hasFile('signature')){

            if($old->emp_signature !='' && $old->emp_signature != null){
                $old_pic = $path.$old->emp_signature;
                unlink($old_pic);
            }

            $imageTake = $request->file('signature');
            $image_signa = 'signa-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/employe/profile/'.$image_signa);

            Employee::where('id',$id)->update([
                'emp_signature'=>$image_signa,
            ]);
        }

        
        $update = Employee::where('id',$id)->update([
            'emp_name'=>$request['name'],
            'emp_dob'=>$request['dob'],
            'email'=>$request['email'],
            'email2'=>$request['email2'],
            'emp_phone'=>$request['phone'],
            'emp_phone2'=>$request['phone2'],
            'emp_address'=>$request['add'],
            'emp_present'=>$request['preAdd'],
            'gender'=>$request['gender'],
            'marriage'=>$request['marriage'],
            'emp_emer_contact'=>$request['emerPhone'],
            'emp_emer_relation'=>$request['emerRelation'],
            'emp_report_manager'=>$request['reporting'],
            'emp_depart_id'=>$request['department'],
            'emp_desig_id'=>$request['desig'],
            'emp_type'=>$request['empType'],

            // identity verification
            'emp_id_type'=>$request['id_type'],
            'emp_id_number'=>$request['id_number'],

            'emp_rec_degree'=>$request['degre'],
            'emp_rec_year'=>$request['degreYear'],

            'emp_bank_id'=>$request['bankName'],
            'emp_bank_branch_id'=>$request['bankBranch'],
            'emp_bank_account_name'=>$request['accountName'],
            'emp_bank_account_number'=>$request['accountNumber'],
            'emp_bank_sort_code'=>$request['sortCode'],
            'emp_bank_swift_code'=>$request['swiftCode'],
            // 'emp_bank_routing_number'=>$request['add'],
            // 'emp_bank_country'=>$request['add'],

            'emp_office_branch_id'=>$request['OffBranch'],
            'emp_office_id_number'=>rand(10000,99999),
            'emp_office_card_number'=>$request['accessCard'],
            'emp_office_IT_requirement'=>$request['system'],
            'emp_office_work_schedule'=>$request['schedule'],

            'emp_slug'=>$slug,
            'emp_join'=>$request['join'],

            'eva_start_date'=>$request->eva_start_date,
            'eva_end_date'=>$request->eva_end_date,

            'emp_resign'=>$request['resign'],
            'emp_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($update){
            if(!empty($request->resign)){
                
                    Employee::where('id',$id)->update([
                        'emp_status'=>3
                    ]);
                Session::flash('success','Employee Have Resigned !');
                return redirect()->back();
            }
            Session::flash('success','Update Employe Details ');
            return redirect()->back();
        }
    }

    public function passwordChange($slug){
        // return $slug;
        $pass = Employee::where('slug',$slug)->first();
        $role= UserRole::all();
        // return $data;
        return view('employe.employe.updateProfile',compact(['pass','role']));
    }

    public function SubmitNewPass(Request $request)
    {
        $id = $request['id'];
        $slug = $request['slug'];
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'email'=>'required | email:rfc,dns',
        ]);

        if($request->hasFile('image')){
            $imageTake = $request->file('image');
            $image_name = 'user-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/admin/profile/'.$image_name);
            
            Employee::where('id',$id)->update([
                'image'=>$image_name,
            ]);
        }
        
        $update = Employee::where('id',$id)->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'slug'=>$slug,
            'updated_at'=>Carbon::now('UTC'),
        ]);
        
        // If Password Is changed
        if($request->oldpass){
            $request->validate([
                'oldpass' => 'required',
                'newpass' => ['required ',\Illuminate\Validation\Rules\Password::min(5)->letters()
                ->numbers()
                ->symbols()],
            ]);
    
            if (!Hash::check($request->oldpass,auth()->user()->password)) {
                return back()->withErrors(['oldpass' => 'Incorrect current password.']);
            }
            auth()->user()->update([
                'password' => Hash::make($request->newpass),
            ]);
        }
        
        Session::flash('success','Profile Update Successfully');
        return redirect()->back();
    }

    // Softy Delete 

    public function softdele(Request $request){
        $id = $request['id'];

        $softdel = Employee::where('id',$id)->update([
            'emp_status'=>0,
            'emp_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($softdel){
            Session::flash('success','Employe is Deactivated!');
            return redirect()->back();
        }
    }

    public function restore(Request $request){
        $id = $request['id'];

        $softdel = Employee::where('id',$id)->update([
            'emp_status'=>1,
            'emp_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($softdel){
            Session::flash('success','Employe is Deactivated!');
            return redirect()->back();
        }
    }
    
    public function delete(Request $request){

        $id = $request['id'];


        $delete = Employee::where('id',$id)->first();
        $delete->delete();
        if($delete){

        Session::flash('success','Employee Delete!');
        return redirect()->back();
        }
    }

    public function login($id)
    {
        $employe = Employee::findOrFail(($id));
        auth('employee')->login($employe, true);
        return redirect()->route('dashboard');
    }
}