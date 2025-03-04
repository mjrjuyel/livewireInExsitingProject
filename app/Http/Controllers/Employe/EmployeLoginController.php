<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeLoginController extends Controller
{

    public function loginEmploye(){
        return view('employe.login');
    }

    public function loginSubmit(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $credential = $request->only('email','password');
        // return $credential;
        // dd($credential, Auth::guard('employee')->attempt($credential));
        if(Auth::guard('employee')->attempt($credential)){
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['email' => 'Invalid email','password'=>'Password Not matched']);
    }

    public function logout()
    {
        // Auth::guard('customer')->logout();
        Auth::guard('employee')->logout();
        return redirect()->route('.');
    }
    
}
