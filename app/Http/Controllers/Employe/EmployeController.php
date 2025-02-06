<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
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
        $view = Employee::where('emp_slug',$slug)->first();
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

        $employe = Employee::findOrFail($id);
        // get associated Admin Info.
        $admin = User::where('email',$employe->email)->first();

        // return $admin;
        $request->validate([
            'name'=>'required',
            'pic' => 'max:512 | image | mimes:jpeg,jpg,png',
            'add' => 'required',
            'emerPhone' => 'required',
            'emerName' => 'required',
            'emerRelation' => 'required',
            'email'=>'required | email:rfc,dns | unique:employees,email,'.$id,
        ]);

        if($request->oldpass != ''){
            if($request->oldpass){
               $request->validate([
                   'oldpass' => 'required',
                   'newpass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()->numbers()],
               ]);
       
               if (!Hash::check($request->oldpass,auth('employee')->user()->password)) {
                   return back()->withErrors(['oldpass' => 'Incorrect current password.']);
               }
               auth('employee')->user()->update([
                   'password' => Hash::make($request->newpass),
               ]);
               // admin password change
               if($admin){
                User::where('id',$admin->$id)->update([
                    'password'=> Hash::make($request->newpass),
                ]);
               }
           }
       }

        $date = strtotime($request['join']);

        // image Change
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

        // admin image change
        if($admin){
                $path = public_path('uploads/adminprofile/');
                if($request->hasFile('pic')){
                    if($admin->image !='' && $admin->image != null){
                        $admin_pic = $path.$admin->image;
                        unlink($admin_pic);
                    }

                    $imageTake = $request->file('pic');
                    $image_name = 'user-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($imageTake);
                    // $image->scale(width: 300);
                    $image->save('uploads/adminprofile/'.$image_name);

                    User::where('id',$admin->id)->update([
                        'image'=>$image_name,
                    ]);
                }
        }
        
        $insert = Employee::where('id',$id)->update([
            'emp_name'=>$request['name'],
            'email'=>$request['email'],
            'email2'=>$request['email2'],
            'emp_phone'=>$request['phone'],
            'emp_phone2'=>$request['phone2'],
            'emp_address'=>$request['add'],
            'emp_present'=>$request['preAdd'],
            'emp_emer_contact'=>$request['emerPhone'],
            'emp_emer_name'=>$request['emerName'],
            'emp_emer_relation'=>$request['emerRelation'],
            'emp_slug'=>$slug,
            'emp_desig_id'=>$request['desig'],
            'updated_at'=>Carbon::now('UTC'),
        ]);

        // Admin Data Change
        if($admin){
            
            $update = User::where('id',$admin->id)->update([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'updated_at'=>Carbon::now('UTC'),
            ]);

            // return $data = User::findOrFail($admin->id);
        }

        if($insert){
            Session::flash('success','Update Profile SuccessFully ');
            return redirect()->route('dashboard.employe.profileSettings',$slug);
        }
    }

    // login into   aDMIN Dashboard

    public function loginAdmin($id){
        $userId = Crypt::decrypt($id);
        $user = User::findOrFail(($userId));
        auth()->login($user, true);
        return redirect()->route('superadmin');
    }

}
