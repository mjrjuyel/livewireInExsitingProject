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
        $employe = Employee::with(['emp_role'=>function($query){
            $query->select('id','role_name');
        },'emp_desig'=>function($query){
            $query->select('id','title');
        },])->latest('id')->get();
        $desig = Designation::with('employe')->get();
        // return $employe;
        return view('employe.employe.all',compact('employe'));
    }

    public function view($slug){
        $view = Employee::with(['emp_role'=>function($query){
            $query->select('id','role_name');
        },'emp_desig'=>function($query){
            $query->select('id','title');
        },])->where('emp_slug',$slug)->first();
        return view('employe.employe.view',compact('view'));
    }

    public function profileSettings($slug){
        // return $slug;
        $edit = Employee::where('emp_slug',$slug)->first();
        // $role= UserRole::all();
        $designation= Designation::all();
        // return $data;
        return view('employe.employe.updateProfile',compact(['edit','designation']));
    }

    public function profileSettingUpdate(Request $request){

        $id = $request['id'];
        $slug = $request['slug'];
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'email'=>'required | email:rfc,dns',
        ]);

        if($request->pass != ''){
             $request->validate([
                'pass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()],
                'repass' => 'required | same:pass',
             ]);

            Employee::where('id',$id)->update([
                'password'=>Hash::make($request['pass']),
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
            'updated_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','Update Profile SuccessFully ');
            return redirect()->route('dashboard.employe.profileSettings',$slug);
        }
    }

}
