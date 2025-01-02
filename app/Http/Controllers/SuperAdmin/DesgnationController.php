<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Department;
use Carbon\Carbon;
use Session;

class DesgnationController extends Controller
{

    //  All Role 
    public function index(){
        $desig = Designation::with(['employe','department'])->get();
        
        // return $desig;
        return view('superadmin.designation.index',compact(['desig']));
    }

    // Add 
    public function add(){
        $depart = Department::all();
        return view('superadmin.designation.add',compact('depart'));
    }
    
    public function insert(Request $request){
        $request->validate([
            'depart'=>'required',
            'title'=>'required | unique:designations,title',
        ]);

        $insert=Designation::create([
            'title'=>$request['title'],
            'depart_id'=>$request['depart'],
            'created_at'=>Carbon::now(),
        ]);

        if($insert){
            Session::flash('success','New Desgnation!');
            return redirect()->back();
        }
    }

    //  Edit Designation 
    public function edit($id){
        $edit = Designation::where('id',$id)->first();
        $depart = Department::all();
        return view('superadmin.designation.edit',compact(['edit','depart']));
    }

    public function update(Request $request){

        $id = $request['id'];
        $request->validate([
            'title'=>'required | unique:designations,title,'.$id,
        ]);
        
        $update = Designation::where('id',$id)->update([
            'title'=>$request['title'],
            'depart_id'=>$request['depart'],
            'updated_at'=>Carbon::now(),
        ]);

        if($update){
            Session::flash('success','Designation Update SuccessFully !');
            return redirect()->back();
        }
    }

    

    public function view($id){
        $view = Designation::with('employe')->where('id',$id)->first();
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

    public function getDesignation($id){
        $data = Designation::where('depart_id',$id)->get();
        return response()->json($data);
    }
}
