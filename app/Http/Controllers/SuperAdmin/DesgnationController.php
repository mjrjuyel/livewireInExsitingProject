<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use Carbon\Carbon;
use Session;

class DesgnationController extends Controller
{
    public function add(){
        return view('superadmin.designation.add');
    }
    
    public function insert(Request $request){
        $request->validate([
            'title'=>'required | unique:designations,title',
        ]);

        $insert=Designation::create([
            'title'=>$request['title'],
            'created_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','New Desgnation!');
            return redirect()->back();
        }
    }
    //  All Role 
    public function index(){
        $desig = Designation::with('admin')->get();
        // return $desig;
        return view('superadmin.designation.index',compact('desig'));
    }

    public function view($id){
        $view = Designation::where('id',$id)->first();
        return view('superadmin.designation.view',compact('view'));
    }

    public function delete($id){
        $delete = Designation::where('id',$id)->first();
        $delete->delete();
        if($delete){
        //     $superadmin = User::all();
        // // Update the auto-incrementing column values
        //     foreach ($superadmin as $index => $row) {
        //         $row->id = $index + 1;
        //         $row->save();
        //     }
        Session::flash('success','Role Delete!');
        return redirect()->back();
        }
    }
}
