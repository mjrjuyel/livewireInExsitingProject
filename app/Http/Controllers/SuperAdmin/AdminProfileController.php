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
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Designation;
use Carbon\Carbon;
use Session;
use Auth;

class AdminProfileController extends Controller
{

    public function __construct(){
        $this->middleware('permission:All Admin')->only('index');
        $this->middleware('permission:Add Admin')->only('add','insert');
        $this->middleware('permission:Edit Admin')->only('profileAdmin');
        $this->middleware('permission:View Admin')->only('view');
        $this->middleware('permission:Delete Admin')->only('delete','softDelete');
    }

    public function index(){
        $alladmin = User::with('roles')->where('status',1)->orderBy('id','ASC')->get();
        
        // return $alladmin;
        return view('superadmin.adminprofile.index',compact('alladmin'));
    }

    public function add(){
        $roles = Role::all();
        return view('superadmin.adminprofile.add',compact('roles'));
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
            'image' => $image_name ?? null,
            'password'=>Hash::make($request['pass']),
            'created_at'=>Carbon::now(),
        ]);

        $insert->syncRoles($request->role);

        if($request->addEmployee){
            $exsitEmploye = Employee::where('email',$insert->email)->exists();

            if($exsitEmploye){
                Session::flash('success','Already Have an Account with This Email . Only Add In Admin List');
                return redirect()->back();
            }
            else{
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
                    'password'=>Hash::make($request['pass']),
                    'created_at'=>Carbon::now(),
                ]);

                Session::flash('success','New Admin and Employee Added Successfully');
                return redirect()->back();
            }

        }

        Session::flash('success','Only Add In Admin List');
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
        $user = User::where('id',$userId)->first();
        $roles = Role::all();
        $ModelRoles= DB::table('model_has_roles')->where('model_id',$userId)->pluck('role_id')->all();
        // return $roles;
        return view('superadmin.adminprofile.updateProfile',compact(['user','roles','ModelRoles']));
    }

    public function updateAdmin(Request $request)
    {
        $id = $request['id'];
        $slug = $request['slug'];
        // return $request->all();
        $request->validate([
            'name'=>'required',
            'image' => 'max:512 | image | mimes:jpeg,jpg,png',
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

        $user = User::findOrFail($id);

        $user->syncRoles($request->role);
        
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

     // soft Delete
     public function softDelete(Request $request){
        $slug = $request['id'];
        
        $softdelete = User::where('status',1)->where('id',$slug)->update([
            'status'=>0,
            'updated_at'=>Carbon::now('UTC'),
        ]);
        if($softdelete){
            Session::flash('error','Moved Into Trash !');
            return redirect()->back();
        }
    }

    public function restore(Request $request){

        $id = $request['id'];

        $store = User::where('id',$id)->update([
            'status'=>1,
            'updated_at'=>Carbon::now('UTC'),
        ]);

        if($store){
            Session::flash('success','Daily Report Restore!');
            return redirect()->back();
        }
    }
    // Delete
    public function delete(Request $request){

        $delete = User::findOrFail($request->id);
        $delete->delete();
        if($delete){
        Session::flash('success','SuperAdmin Dashboard User Delete Successfully!');
        return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/login');
    }
}
