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
use App\Models\Designation;
use Carbon\Carbon;
use Session;
use Auth;

class AdminEmployeController extends Controller
{
    // Add Employe 
    public function add(){
        $role = UserRole::all();
        $designation= Designation::all();
        return view('superadmin.employe.add',compact(['role','designation']));
    }
    public function insert(Request $request){
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'email'=>'required | email:rfc,dns | unique:employees,email',
            'phone'=>'required',
            'pass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()
            ->numbers()
            ->symbols()],
            'repass' => 'required | same:pass',
            
        ]);

        $date = strtotime($request['join']);

        if($request->hasFile('pic')){
            $imageTake = $request->file('pic');
            $image_name = 'emp-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/employe/profile/'.$image_name);
        }
        
        $insert = Employee::create([
            'emp_name'=>$request['name'],
            'email'=>$request['email1'],
            'emp_phone'=>$request['phone'],
            'emp_address'=>$request['add'],
            'emp_image'=>$image_name ?? null,
            'emp_slug'=>'emp-'.uniqId(),
            'emp_desig_id'=>$request['desig'],
            'emp_role_id'=>$request['role'],
            'emp_join'=>$request['join'],
            'password'=>Hash::make($request['pass']),
            'emp_creator'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
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

        $whole_approved_leave = Leave::where('emp_id',$view->id)->where('status',2)->sum('total_leave_this_month');
        $leaveRequestInMonth = Leave::where('emp_id',$view->id)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->count();
        $leaveRequestInYear = Leave::where('emp_id',$view->id)->whereYear('start_date',date('Y'))->count();

        $paidRemainingMonth = Leave::where('emp_id',$view->id)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_paid');
        $paidRemainingYear = Leave::where('emp_id',$view->id)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_paid');

        $unpaidRemainingMonth = Leave::where('emp_id',$view->id)->where('status',2)->whereMonth('start_date',date('m'))->whereYear('start_date',date('Y'))->sum('total_unpaid');
        $unpaidRemainingYear = Leave::where('emp_id',$view->id)->where('status',2)->whereYear('start_date',date('Y'))->sum('total_unpaid');

        // return $paidRemainingYear;
        return view('superadmin.employe.view',compact(['view','activeEmploye','leaveRequestInMonth','leaveRequestInYear','paidRemainingMonth','whole_approved_leave','paidRemainingYear','defaultLeave','unpaidRemainingMonth','unpaidRemainingYear']));
    }

    // Edit Admin
    public function edit($slug){
        $edit= Employee::where('emp_slug',$slug)->first();
        $role= UserRole::all();
        $designation= Designation::all();
        // return $role;
        return view('superadmin.employe.edit',compact(['edit','role','designation']));
    }

    public function update(Request $request){

        $id = $request['id'];
        $slug = $request['slug'];
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'email'=>'required | email:rfc,dns | unique:employees,email,'.$id,
            'phone'=>'required',
        ]);

        if($request->pass != ''){
            $request->validate([
                'pass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()
                ->numbers()
                ->symbols()],
                'repass' => 'required | same:pass',
             ]);

            Employee::where('id',$id)->update([
                'pass'=>$request['pass'],
            ]);
        }

        $date = strtotime($request['join']);

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
        
        $insert = Employee::where('id',$id)->update([
            'emp_name'=>$request['name'],
            'email'=>$request['email'],
            'emp_phone'=>$request['phone'],
            'emp_address'=>$request['add'],
            'emp_slug'=>$slug,
            'emp_desig_id'=>$request['desig'],
            'emp_role_id'=>$request['role'],
            'emp_join'=>$request['join'],
            'emp_resign'=>$request['resign'],
            'emp_status'=>$request['status'],
            'emp_editor'=>Auth::user()->id,
            'updated_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','Employee Edit SuccessFully ');
            return redirect()->route('superadmin.employe.view',$slug);
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
            'updated_at'=>Carbon::now(),
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
            'updated_at'=>Carbon::now(),
        ]);

        if($softdel){
            Session::flash('success','Employe is Deactivated!');
            return redirect()->back();
        }
    }
    
    public function delete($slug){
        $delete = Employee::where('slug',$slug)->first();
        $delete->delete();
        if($delete){
        //     $admin = Employee::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('success',' One Admin Delete!');
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