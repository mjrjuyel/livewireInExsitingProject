<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeLoginController extends Controller
{

    public function login(){
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
        return back()->withErrors(['login' => 'Invalid email or password.']);
    }

    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect()->route('employe.login');
    }
}
