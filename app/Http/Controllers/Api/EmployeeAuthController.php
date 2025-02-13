<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;
use DB;

class EmployeeAuthController extends Controller
{
    public function index(){
        try{
            $employes = User::all();
        return response()->json([
            'status'=>true,
            'Message'=>'All Employee Fetch Success Fully',
            'Data'=>$employes,
        ],200);
        }
        catch(Exception $e){
        return response()->json([
            'status'=>false,
            'Message'=>$e->getMessage(),
        ],501);
        }
    }

    // employee Login Dashboard
    public function loginEmploye(Request $request){

        // nurul vai
        $employee = Employee::select('id', 'emp_name', 'email','email2', 'emp_phone', 'emp_phone2', 'emp_address', 'emp_present', 'emp_emer_contact', 'emp_emer_name', 'emp_emer_relation', 'emp_dob', 'gender', 'marriage', 'emp_image', 'emp_status', 'emp_report_manager', 'emp_depart_id','emp_desig_id','emp_type','emp_join','emp_resign','emp_id_type','emp_id_number','emp_rec_degree','emp_rec_year','emp_bank_id','emp_bank_branch_id', 'emp_bank_account_name','emp_bank_account_number','remember_token','device_token')->Where('email', $request->email)->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.',
                'token' => null,
                'user' => null,
            ],404);
        }
        DB::table('employees')
            ->where('device_token', $employee->device_token)
            ->where('id', '!=', $employee->id)
            ->update(['device_token' => null]);

            if ($employee && Auth::guard('employee')->attempt(['email' => $employee->email, 'password' => $request->password])) {
                $token = $employee->createToken('MyApp')->plainTextToken;
                return response()->json([
                    'success' => true,
                    'message' => 'User login successfully.',
                    'token' => $token,
                    'user' => $employee,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid password.',
                    'token' => null,
                    'user' => null,
                ]);
            }  
    }

    // public function login(Request $request)
    // {
    //     $user = User::select('id', 'is_premium', 'type_id', 'fire_station', 'hospital_agency', 'area_limit', 'first_name', 'last_name', 'email', 'phone', 'dob', 'gender', 'nid', 'address', 'profile_pic', 'email_verified_at', 'premium_expire_at', 'device_token')->Where('phone', $request->emailOrphone)->first();
    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'User not found.',
    //             'token' => null,
    //             'user' => null,
    //         ]);
    //     }
    //     DB::table('users')
    //         ->where('device_token', $user->device_token)
    //         ->where('id', '!=', $user->id)
    //         ->update(['device_token' => null]);

    //     if ($user && Auth::attempt(['phone' => $user->phone, 'password' => $request->password])) {
    //         $token = $user->createToken('MyApp')->plainTextToken;
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User login successfully.',
    //             'token' => $token,
    //             'user' => [
    //                 'id' => $user->id,
    //                 'type_id' => $user->type_id,
    //                 'first_name' => $user->first_name,
    //                 'last_name' => $user->last_name,
    //                 'email' => $user->email,
    //                 'phone' => $user->phone,
    //                 'profile_pic' => $user->profile_pic ? asset('storage/' . $user->profile_pic) : null,
    //                 'police_id' => $user->police ? $user->police->police_id : null,
    //                 'thana' => $user->police ? $user->police->thana->name : null,
    //                 'fire_station' => $user->fire_station,
    //                 'hospital_agency' => $user->hospital_agency,
    //                 'dob' => $user->dob,
    //                 'gender' => $user->gender,
    //                 'nid' => $user->nid,
    //                 'area_limit' => $user->area_limit,
    //                 'address' => $user->address,
    //                 'is_email_verified' => $user->email_verified_at ? true : false,
    //                 'is_phone_verified' => true,
    //                 'premium_info' => [
    //                     'is_premium' => $user->is_premium,
    //                     'premium_expire_at' => $user->premium_expire_at
    //                 ]
    //             ]
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Invalid password.',
    //             'token' => null,
    //             'user' => null,
    //         ]);
    //     }
    // }

    // Employee LogoUt Dashboard
    public function logoutEmploye(Request $request){
       try{

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully.',
        ]);

        }
       catch(Exception $e){
        return response()->json([
            'status'=>true,
            "message"=>$e->getMesaage(),
             ],404);
       }
    }

}
