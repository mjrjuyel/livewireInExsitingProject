<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Employee;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Designation;
use App\Models\EmployeePromotion;
use App\Models\EmployeeEvaluation;
use Carbon\Carbon;
use Session;

class EmployeeController extends Controller
{
    
}
