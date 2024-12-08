<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\UserRole;
use App\Models\Designation;
use Carbon\Carbon;
use Session;

class EmployeController extends Controller
{
    public function index(){
        $employe = Employee::with(['emp_role','emp_desig'])->latest('id')->get();
        $desig = Designation::with('employe')->get();
        // return $desig;
        return view('employe.employe.all',compact('employe'));
    }

    public function view($slug){
        $view = Employee::where('emp_slug',$slug)->first();
        return view('employe.employe.view',compact('view'));
    }

    // Edit Admin
    public function edit($slug){
        $edit= Employee::where('emp_slug',$slug)->where('status',1)->first();
        $role= UserRole::all();
        $designation= Designation::all();
        // return $role;
        return view('employe.employe.edit',compact(['edit','role','designation']));
    }

    public function update(Request $request){
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
            $image->save('uploads/employe/profile/'.$image_name);
            
            Employee::where('id',$id)->update([
                'image'=>$image_name,
            ]);

            Session::flash('success','Profile Update Successfully');
            return redirect()->route('dashboard.admin');
        }
        
        $update = Employee::where('id',$id)->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'role_id'=>$request['role'],
            'designation_id'=>$request['designation'],
            'slug'=>$slug,
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Profile Update Successfully');
            return redirect()->route('dashboard.admin');
        }
    }

    public function passwordChange($slug){
        // return $slug;
        $pass = Employee::where('emp_slug',$slug)->first();
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
                'newpass' => 'required|min:8',]);
    
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

}
