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

    // employee Login Dashboard
    public function loginEmploye(Request $request){

        // nurul vai
        try{
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
                ],200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid password.',
                    'token' => null,
                    'user' => null,
                ],201);
            }
        }  
        catch(Exceptional $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],404);
        }
    }

    // Logout Employee
    public function logoutEmploye(Request $request){
       try{
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully.',
        ],200);

        }
       catch(Exception $e){
        return response()->json([
            'status'=>true,
            "message"=>$e->getMesaage(),
             ],404);
       }
    }
}
