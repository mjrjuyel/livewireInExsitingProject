<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// For Employe Controller 
use App\Http\Controllers\Employe\DashboardController;
use App\Http\Controllers\Employe\RoleController;
use App\Http\Controllers\Employe\LeaveFormController;
use App\Http\Controllers\Employe\EmployeController; // Default Admin Model Work With User Model , Here we can fetch Data from User Model.
use App\Http\Controllers\Employe\EmployeLoginController;

// Super Admin Dashboard
use App\Http\Controllers\SuperAdmin\AdminProfileController; 
use App\Http\Controllers\Employe\SuperAdminController; 
use App\Http\Controllers\SuperAdmin\AdminEmployeController; // Employe Management as a SuperAdmin
use App\Http\Controllers\SuperAdmin\BasicController;
use App\Http\Controllers\SuperAdmin\DesgnationController;
use App\Http\Controllers\SuperAdmin\SuperAdminLeaveController;


Route::get('/', function () {
    return view('welcome');
});


// Employe Login ======
Route::get('/employe/login',[EmployeLoginController::class,'login'])->name('employe.login');
Route::post('/employe/loginsubmit',[EmployeLoginController::class,'loginSubmit']);

// ========= Employe Dashboard
Route::middleware('isEmploye')->group(function(){
    // Logout 
        Route::post('/employe/logout', [EmployeLoginController::class, 'logout'])->name('employe.logout');
        // Dsahboard Index
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
        // Admin Controller 
        Route::get('/dashboard/employe',[EmployeController::class,'index'])->name('dashboard.employe');
        Route::get('/dashboard/employe/view/{slug}',[EmployeController::class,'view'])->name('dashboard.employe.view');
        Route::get('/dashboard/employe/edit/{slug}',[EmployeController::class,'edit'])->name('dashboard.employe.edit');
        Route::post('/dashboard/employe/update',[EmployeController::class,'update'])->name('dashboard.employe.update');
        Route::get('/dashboard/employe/passwordChange/{slug}',[EmployeController::class,'passwordChange'])->name('dashboard.employe.passwordChange');
        Route::post('/dashboard/employe/passwordChangeSubmit',[EmployeController::class,'SubmitNewPass'])->name('dashboard.employe.passwordChangeSubmit');
        Route::post('/dashboard/employe/delete',[EmployeController::class,'delete'])->name('dashboard.employe.delete');
    // Role ManageMent
        Route::get('/dashboard/role',[RoleController::class,'index'])->name('dashboard.role');
        Route::get('/dashboard/role/add',[RoleController::class,'add'])->name('dashboard.role.add');
        Route::post('/dashboard/role/insert',[RoleController::class,'insert'])->name('dashboard.role.insert');
        Route::get('/dashboard/role/view/{id}',[RoleController::class,'view'])->name('dashboard.role.view');
        Route::delete('/dashboard/role/delete/{id}',[RoleController::class,'delete'])->name('dashboard.role.view');
    
    // Leave Application status by General User
        Route::get('/dashboard/leave/add',[LeaveFormController::class,'add'])->name('dashboard.leave.add');
        Route::post('/dashboard/leave/insert',[LeaveFormController::class,'insert'])->name('dashboard.leave.insert');
        Route::get('/dashboard/leave/view/{slug}',[LeaveFormController::class,'view'])->name('dashboard.leave.view'); 
});


Route::middleware(['auth','verified'])->group(function(){
    // Super Admin Dashbaord
    Route::middleware('is_superadmin')->group(function(){
        // Admin Profile Controller 
        Route::get('superadmin/profile/{slug}',[AdminProfileController::class,'profileAdmin'])->name('superadmin.profile');
        Route::post('superadmin/profile/update',[AdminProfileController::class,'updateAdmin'])->name('superadmin.profile.update');

        Route::get('/superadmin',[SuperAdminController::class,'dashboard'])->name('superadmin');
        // Admin Edit Access 
        // Route::get('/dashboard/admin/edit/{slug}',[AdminController::class,'edit'])->name('dashboard.admin.edit');
        // Route::delete('/dashboard/admin/delete/{slug}',[AdminController::class,'delete'])->name('dashboard.admin.view');
        //SuperAdmin Basic Controller

        Route::get('/superadmin/basic',[BasicController::class,'index'])->name('superadmin.basic');
        // Add Employer Controller
        Route::get('/superadmin/employe',[AdminEmployeController::class,'index'])->name('superadmin.employe');
        Route::get('/superadmin/employe/add',[AdminEmployeController::class,'add'])->name('superadmin.employe.add');
        Route::post('/superadmin/employe/insert',[AdminEmployeController::class,'insert'])->name('superadmin.employe.insert');
        Route::get('/superadmin/employe/edit/{slug}',[AdminEmployeController::class,'edit'])->name('superadmin.employe.edit');
        Route::post('/superadmin/employe/update',[AdminEmployeController::class,'update'])->name('superadmin.employe.update');
        Route::post('/superadmin/employe/softdelete',[AdminEmployeController::class,'softdel'])->name('superadmin.employe.softdelete');
        Route::get('/superadmin/employe/view/{slug}',[AdminEmployeController::class,'view'])->name('superadmin.employe.view');
        Route::delete('/superadmin/employe/delete',[AdminEmployeController::class,'delete'])->name('superadmin.employe.delete');
        // Designation Controller
        Route::get('/superadmin/designation',[DesgnationController::class,'index'])->name('superadmin.designation');
        Route::get('/superadmin/designation/add',[DesgnationController::class,'add'])->name('superadmin.designation.add');
        Route::post('/superadmin/designation/insert',[DesgnationController::class,'insert'])->name('superadmin.designation.insert');
        Route::get('/superadmin/designation/view/{id}',[DesgnationController::class,'view'])->name('superadmin.designation.view');
        Route::delete('/superadmin/designation/delete/{id}',[DesgnationController::class,'delete'])->name('superadmin.designation.view');
        // Leave Application status
        Route::get('/superadmin/leave',[SuperAdminLeaveController::class,'index'])->name('superadmin.leave');
        // Route::get('/dashboard/leave/add',[LeaveFormController::class,'add'])->name('dashboard.leave.add');
        Route::post('/superadmin/leave/insert',[SuperAdminLeaveController::class,'insert'])->name('superadmin.leave.insert');
        Route::get('/superadmin/leave/view/{slug}',[SuperAdminLeaveController::class,'view'])->name('superadmin.leave.view');
        Route::post('/superadmin/leave/upadte',[SuperAdminLeaveController::class,'update'])->name('superadmin.leave.upadte');
        Route::delete('/superadmin/leave/delete/{slug}',[SuperAdminLeaveController::class,'delete'])->name('superadmin.leave.view');
    });

    // Not As A Super Admin
    Route::get('invalidAccess',function(){ 
        return view('layouts.errorpage.notValidRole');
        })->name('invalidAccess');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
