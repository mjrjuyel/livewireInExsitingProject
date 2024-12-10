<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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

    public function profileSettings($slug){
        // return $slug;
        $edit = Employee::where('emp_slug',$slug)->first();
        $role= UserRole::all();
        $designation= Designation::all();
        // return $data;
        return view('employe.employe.updateProfile',compact(['edit','role','designation']));
    }

    public function profileSettingUpdate(Request $request){

        $id = $request['id'];
        $slug = $request['slug'];
        // return $request->all();
           // return $request->all();
        $request->validate([
            'name'=>'required',
            'email'=>'required | email:rfc,dns',
        ]);

        if($request->pass != ''){
             $request->validate([
                'pass' => ['required',\Illuminate\Validation\Rules\Password::min(4)->letters()],
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
            'emp_status'=>$request['status'],
            'updated_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','Update Profile SuccessFully ');
            return redirect()->route('dashboard.employe.profileSettings',$slug);
        }
    }

}
