<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Designation;
use Carbon\Carbon;
use Session;
use Auth;

class AdminProfileController extends Controller
{
    public function profileAdmin($slug){
        // return $slug;
        $pass = User::where('slug',$slug)->first();
        $role= UserRole::all();
        // return $pass;
        return view('superadmin.adminprofile.updateProfile',compact(['pass','role']));
    }

    public function updateAdmin(Request $request)
    {
        $id = $request['id'];
        $slug = $request['slug'];
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'email'=>'required | email:rfc,dns | unique:users,name,'.$id,
        ]);

        $old= User::find($id);
        $path = public_path('uploads/adminprofile/');

        if($request->hasFile('image')){
        // remove old Image
            if($old->image != '' && $old->image != null){
                $old_pic = $path.$old->image;
                unlink($old_pic);
            }

            $imageTake = $request->file('image');
            $image_name = 'user-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/adminprofile/'.$image_name);
            
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
                'newpass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters(1)->numbers(1)->symbols()],
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
}
