<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// For Admin Controller 
use App\Http\Controllers\Employe\DashboardController;
use App\Http\Controllers\Employe\RoleController;
use App\Http\Controllers\Employe\LeaveFormController;
use App\Http\Controllers\Employe\EmployeController; // Default Admin Model Work With User Model , Here we can fetch Data from User Model.

// Super Admin Dashboard
use App\Http\Controllers\Employe\SuperAdminController; 
use App\Http\Controllers\SuperAdmin\BasicController;
use App\Http\Controllers\SuperAdmin\DesgnationController;
use App\Http\Controllers\SuperAdmin\SuperAdminLeaveController;


Route::get('/', function () {
    return view('welcome');
});


// Dashboard Controller 


Route::middleware(['auth','verified'])->group(function(){
    // Dsahboard Index
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    // Admin Controller 
    Route::get('/dashboard/admin',[EmployeController::class,'index'])->name('dashboard.admin');
    Route::get('/dashboard/admin/view/{slug}',[EmployeController::class,'view'])->name('dashboard.admin.view');
    Route::post('/dashboard/admin/update',[EmployeController::class,'update'])->name('dashboard.admin.update');
    Route::get('/dashboard/admin/passwordChange/{slug}',[EmployeController::class,'passwordChange'])->name('dashboard.admin.passwordChange');
    Route::post('/dashboard/admin/passwordChangeSubmit',[EmployeController::class,'SubmitNewPass'])->name('dashboard.admin.passwordChangeSubmit');
    
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

    
    // Super Admin Dashbaord
    Route::middleware('superAdmin')->group(function(){
        Route::get('/dashboard/superAdmin',[SuperAdminController::class,'dashboard'])->name('dashboard.superAdmin');
        // Admin Edit Access 
        Route::get('/dashboard/admin/edit/{slug}',[AdminController::class,'edit'])->name('dashboard.admin.edit');
        Route::delete('/dashboard/admin/delete/{slug}',[AdminController::class,'delete'])->name('dashboard.admin.view');
        //SuperAdmin Basic Controller
        Route::get('/dashboard/superAdmin/basic',[BasicController::class,'index'])->name('dashboard.superAdmin.basic');

        // Designation Controller
        Route::get('/dashboard/superadmin/designation',[DesgnationController::class,'index'])->name('dashboard.superadmin.designation');
        Route::get('/dashboard/superadmin/designation/add',[DesgnationController::class,'add'])->name('dashboard.superadmin.designation.add');
        Route::post('/dashboard/superadmin/designation/insert',[DesgnationController::class,'insert'])->name('dashboard.superadmin.designation.insert');
        Route::get('/dashboard/superadmin/designation/view/{id}',[DesgnationController::class,'view'])->name('dashboard.superadmin.designation.view');
        Route::delete('/dashboard/superadmin/designation/delete/{id}',[DesgnationController::class,'delete'])->name('dashboard.superadmin.designation.view');

        // Leave Application status
        Route::get('/dashboard/superAdmin/leave',[SuperAdminLeaveController::class,'index'])->name('dashboard.superAdmin.leave');
        // Route::get('/dashboard/leave/add',[LeaveFormController::class,'add'])->name('dashboard.leave.add');
        Route::post('/dashboard/superAdmin/leave/insert',[SuperAdminLeaveController::class,'insert'])->name('dashboard.superAdmin.leave.insert');
        Route::get('/dashboard/superAdmin/leave/view/{slug}',[SuperAdminLeaveController::class,'view'])->name('dashboard.superAdmin.leave.view');
        Route::post('/dashboard/superAdmin/leave/upadte',[SuperAdminLeaveController::class,'update'])->name('dashboard.superAdmin.leave.upadte');
        Route::delete('/dashboard/superAdmin/leave/delete/{slug}',[SuperAdminLeaveController::class,'delete'])->name('dashboard.superAdmin.leave.view');
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
