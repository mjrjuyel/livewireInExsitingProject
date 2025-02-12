<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EarlyLeave;
use Illuminate\Support\Facades\Crypt;

class AdminEarlyLeaveController extends Controller
{
    public function index(){
        $leaves = EarlyLeave::where('status','!=',0)->latest('id')->get();
        // return $leaves;
        return view('superadmin.earlyleave.index',compact('leaves'));
    }

    public function view($id){
        $Id = Crypt::decrypt($id);
        $view = EarlyLeave::findOrFail($Id);
        return view('superadmin.earlyleave.view',compact('view'));
    }

}
