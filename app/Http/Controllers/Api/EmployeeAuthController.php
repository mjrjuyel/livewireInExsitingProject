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
use Carbon\Carbon;

class EmployeeAuthController extends Controller
{

    // employee Login Dashboard
    public function login(Request $request){

        // nurul vai
        try{
            $user = User::select('id', 'name', 'email','email2', 'phone', 'phone2', 'address', 'present', 'emer_contact', 'emer_name', 'emer_relation', 'dob', 'gender', 'marriage', 'image', 'status', 'report_manager', 'depart_id','desig_id','emp_type','join_date','resign_date','id_type','id_number','rec_degree','rec_year','bank_id','bank_branch_id', 'bank_account_name','bank_account_number','remember_token','device_token','creator','editor',)->with(['reporting:id,name','department:id,depart_name','emp_desig:id,title','bankName:id,bank_name','bankBranch:id,bank_branch_name','officeBranch:id,branch_name','creator:id,name','editor:id,name'])->Where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
                'token' => null,
                'user' => null,
            ],404);
        }
        DB::table('users')
            ->where('device_token', $user->device_token)
            ->where('id', '!=', $user->id)
            ->update(['device_token' => null]);

            if ($user && Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                $token = $user->createToken('MyApp')->plainTextToken;
                
                $user->tokens()->latest()->first()->update([
                    'expires_at' => Carbon::now()->addMinutes(60)
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'User login successfully.',
                    'image_path' => asset('uploads/employe/profile/'),
                    'image'=>$user->image,
                    'token' => $token,
                    'user' => $user,
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
    public function logout(Request $request){
       try{

        $user = auth()->user();
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        
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
