<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Crypt;
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

    public function index(){
        $alladmin = User::where('status',1)->orderBy('role_id')->get();
        // return $alladmin;
        return view('superadmin.adminprofile.index',compact('alladmin'));
    }

    public function add(){
        $role = UserRole::all();
        return view('superadmin.adminprofile.add',compact('role'));
    }

    public function insert(Request $request){
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'pic' => 'mimes:jpeg.jpg,png',
            'email'=>'required | email:rfc,dns | unique:users,email',
            'role' => 'required',
            'pass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()
            ->numbers()
            ->symbols()],
            'repass' => 'required | same:pass',
        ]);

        if($request->hasFile('pic')){
            $imageTake = $request->file('pic');
            $image_name = 'user-'.uniqId().'.'.$imageTake->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageTake);
            // $image->scale(width: 300);
            $image->save('uploads/adminprofile/'.$image_name);
        }
        
        $insert = User::create([
            'name'=>$request['name'],
            'username'=>$request['user'],
            'email'=>$request['email'],
            'slug'=>'user-'.uniqId(),
            'role_id'=>$request['role'],
            'image' => $image_name ?? null,
            'password'=>$request['pass'],
            'created_at'=>Carbon::now(),
        ]);
        if($insert){
               if($insert->image){
                $imageTake = $request->file('pic');
                $employe_name = 'user-'.uniqId().$insert->image;
                // $image->scale(width: 300);
                $image->save('uploads/employe/profile/'.$employe_name);
               }
                $employe = Employee::create([
                'emp_name'=>$insert->name,
                'email'=>$insert->email,
                'emp_image'=>$employe_name ?? null,
                'emp_join'=>Carbon::now()->format('Y-m-d'),
                'emp_slug'=>'user-'.uniqId(),
                'emp_creator'=>Auth::user()->id,
                'password'=>$request['pass'],
                'created_at'=>Carbon::now(),
            ]);
        }
        
        Session::flash('success','New Admin Added Successfully');
        return redirect()->back();
    }

    public function viewProfile($id){
        $userId = Crypt::decrypt($id);
        // return $userId;
        $view = User::where('id',$userId)->first();
        return view('superadmin.adminprofile.view',compact('view'));
    }

    public function profileAdmin($slug){
        // return $slug;
        $userId = Crypt::decrypt($slug);
        $pass = User::where('id',$userId)->first();
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
            'image' => 'max:512 | image | mimes:jpeg.jpg,png',
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
                'newpass' => ['required',\Illuminate\Validation\Rules\Password::min(5)->letters()->numbers()],
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
