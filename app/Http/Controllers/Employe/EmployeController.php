<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Designation;
use Carbon\Carbon;
use Session;

class EmployeController extends Controller
{
    public function index(){
        $admin = User::with('role')->latest('id')->get();
        // return $admin;
        return view('admin.admin.all',compact('admin'));
    }

    public function view($slug){
        $view = User::where('slug',$slug)->first();
        return view('admin.admin.view',compact('view'));
    }

    // Edit Admin
    public function edit($slug){
        $edit= User::where('slug',$slug)->where('status',1)->first();
        $role= UserRole::all();
        $designation= Designation::all();
        // return $role;
        return view('admin.admin.edit',compact(['edit','role','designation']));
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
            $image->save('uploads/admin/profile/'.$image_name);
            
            User::where('id',$id)->update([
                'image'=>$image_name,
            ]);

            Session::flash('success','Profile Update Successfully');
            return redirect()->route('dashboard.admin');
        }
        
        $update = User::where('id',$id)->update([
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
        $pass = User::where('slug',$slug)->first();
        $role= UserRole::all();
        // return $data;
        return view('admin.admin.updateProfile',compact(['pass','role']));
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
            
            User::where('id',$id)->update([
                'image'=>$image_name,
            ]);
        }
        
        $update = User::where('id',$id)->update([
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

    public function delete($slug){
        $delete = User::where('slug',$slug)->first();
        $delete->delete();
        if($delete){
        //     $admin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($admin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('success',' One Admin Delete!');
        return redirect()->back();
        }
    }
}
