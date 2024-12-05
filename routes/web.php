<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// For Admin Controller 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController; // Default Admin Model Work With User Model , Here we can fetch Data from User Model.

// Super Admin Dashboard
use App\Http\Controllers\Admin\SuperAdminController; 
use App\Http\Controllers\SuperAdmin\BasicController;
use App\Http\Controllers\SuperAdmin\DesgnationController;


Route::get('/', function () {
    return view('welcome');
});


// Dashboard Controller 


Route::middleware(['auth','verified'])->group(function(){
    // Dsahboard Index
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    // Admin Controller 
    Route::get('/dashboard/admin',[AdminController::class,'index'])->name('dashboard.admin');
    Route::get('/dashboard/admin/view/{slug}',[AdminController::class,'view'])->name('dashboard.admin.view');
    Route::post('/dashboard/admin/update',[AdminController::class,'update'])->name('dashboard.admin.update');
    Route::get('/dashboard/admin/passwordChange/{slug}',[AdminController::class,'passwordChange'])->name('dashboard.admin.passwordChange');
    Route::post('/dashboard/admin/passwordChangeSubmit',[AdminController::class,'SubmitNewPass'])->name('dashboard.admin.passwordChangeSubmit');
    
// Role ManageMent
    Route::get('/dashboard/role',[RoleController::class,'index'])->name('dashboard.role');
    Route::get('/dashboard/role/add',[RoleController::class,'add'])->name('dashboard.role.add');
    Route::post('/dashboard/role/insert',[RoleController::class,'insert'])->name('dashboard.role.insert');
    Route::get('/dashboard/role/view/{id}',[RoleController::class,'view'])->name('dashboard.role.view');
    Route::delete('/dashboard/role/delete/{id}',[RoleController::class,'delete'])->name('dashboard.role.view');

    
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
