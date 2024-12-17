<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

// For Employe Controller 
use App\Http\Controllers\Employe\DashboardController;
use App\Http\Controllers\Employe\RoleController;
use App\Http\Controllers\Employe\LeaveFormController;
use App\Http\Controllers\Employe\DailyReportController;
use App\Http\Controllers\Employe\EmployeController; // Default Admin Model Work With User Model , Here we can fetch Data from User Model.

use App\Http\Controllers\Employe\EmployeLoginController;

// Super Admin Dashboard
use App\Http\Controllers\SuperAdmin\AdminProfileController; //Admin Profile Controller 
use App\Http\Controllers\Employe\SuperAdminController; // super Admin can Add Edit And Delete Employe.
use App\Http\Controllers\SuperAdmin\AdminEmployeController; // Employe Management as a SuperAdmin // super Admin can Add Edit And Delete Employe.
use App\Http\Controllers\SuperAdmin\BasicController;
use App\Http\Controllers\SuperAdmin\DesgnationController; // super Admin can add more designation.
use App\Http\Controllers\SuperAdmin\SuperAdminLeaveController; // Super Admin Manage Employee Leave request.
use App\Http\Controllers\SuperAdmin\AdminDailyReportController; /// Super admin can view detail who send dailyreport.
use App\Http\Controllers\SuperAdmin\AdminRoleController; /// Role Create,View,edit,delete.
use App\Http\Controllers\SuperAdmin\LeaveSettingController; // Leave Settings .


Route::get('/', function () {
    return view('welcome');
})->name('.');


// Employe Login ======
Route::get('/employe/login',[EmployeLoginController::class,'loginEmploye'])->name('employe.login');
Route::post('/employe/loginsubmit',[EmployeLoginController::class,'loginSubmit'])->name('employe.loginsubmit');

// ========= Employe Dashboard
Route::middleware('isEmploye')->group(function(){
    // Logout 
        Route::post('/employe/logout', [EmployeLoginController::class, 'logout'])->name('employe.logout');
        // Dsahboard Index
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
        // Admin Controller 
        Route::get('/dashboard/employe',[EmployeController::class,'index'])->name('dashboard.employe');
        Route::get('/dashboard/employe/view/{slug}',[EmployeController::class,'view'])->name('dashboard.employe.view');
        // Route::get('/dashboard/employe/edit/{slug}',[EmployeController::class,'edit'])->name('dashboard.employe.edit');
        // Route::post('/dashboard/employe/update',[EmployeController::class,'update'])->name('dashboard.employe.update');
        Route::get('/dashboard/employe/profileSettings/{slug}',[EmployeController::class,'profileSettings'])->name('dashboard.employe.profileSettings');
        Route::post('/dashboard/employe/profileSettingUpdate',[EmployeController::class,'profileSettingUpdate'])->name('dashboard.employe.profileSettingUpdate');
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
        Route::get('/dashboard/leave/history/{slug}',[LeaveFormController::class,'history'])->name('dashboard.leave.history'); 

        // Employe Daily Reports Submit
        Route::get('/dashboard/dailyreport',[DailyReportController::class,'index'])->name('dashboard.dailyreport');
        Route::get('/dashboard/dailyreport/add',[DailyReportController::class,'add'])->name('dashboard.dailyreport.add');
        Route::post('/dashboard/dailyreport/submit',[DailyReportController::class,'submit'])->name('dashboard.dailyreport.submit'); 
        Route::get('/dashboard/dailyreport/view/{slug}',[DailyReportController::class,'view'])->name('dashboard.dailyreport.view'); 
});


// Super Admin Dashboard

Route::middleware(['auth','verified'])->group(function(){

    Route::get('/superadmin',[SuperAdminController::class,'dashboard'])->name('superadmin');
    // Super Admin Dashbaord
    Route::middleware('is_superadmin')->group(function(){
        // Admin Profile Controller 
        Route::get('superadmin/profile/{slug}',[AdminProfileController::class,'profileAdmin'])->name('superadmin.profile');
        Route::post('superadmin/profile/update',[AdminProfileController::class,'updateAdmin'])->name('superadmin.profile.update');

        
        // Admin Edit Access 
        // Route::get('/dashboard/admin/edit/{slug}',[AdminController::class,'edit'])->name('dashboard.admin.edit');
        // Route::delete('/dashboard/admin/delete/{slug}',[AdminController::class,'delete'])->name('dashboard.admin.view');
        
        // Add Employer Controller
        Route::get('/superadmin/employe',[AdminEmployeController::class,'index'])->name('superadmin.employe');
        Route::get('/superadmin/employe/add',[AdminEmployeController::class,'add'])->name('superadmin.employe.add');
        Route::post('/superadmin/employe/insert',[AdminEmployeController::class,'insert'])->name('superadmin.employe.insert');
        Route::get('/superadmin/employe/edit/{slug}',[AdminEmployeController::class,'edit'])->name('superadmin.employe.edit');
        Route::post('/superadmin/employe/update',[AdminEmployeController::class,'update'])->name('superadmin.employe.update');
        Route::post('/superadmin/employe/softdelete',[AdminEmployeController::class,'softdel'])->name('superadmin.employe.softdelete');
        Route::get('/superadmin/employe/view/{slug}',[AdminEmployeController::class,'view'])->name('superadmin.employe.view');
        Route::delete('/superadmin/employe/delete',[AdminEmployeController::class,'delete'])->name('superadmin.employe.delete');
        // log in as a employee
        Route::post('/superadmin/employe/login/{id}',[AdminEmployeController::class,'login'])->name('superadmin.employe.login');
        // Designation Controller
        Route::get('/superadmin/designation',[DesgnationController::class,'index'])->name('superadmin.designation');
        Route::get('/superadmin/designation/add',[DesgnationController::class,'add'])->name('superadmin.designation.add');
        Route::post('/superadmin/designation/insert',[DesgnationController::class,'insert'])->name('superadmin.designation.insert');
        Route::get('/superadmin/designation/view/{id}',[DesgnationController::class,'view'])->name('superadmin.designation.view');
        Route::get('/superadmin/designation/edit/{id}',[DesgnationController::class,'edit'])->name('superadmin.designation.edit');
        Route::get('/superadmin/designation/edit',[DesgnationController::class,'update'])->name('superadmin.designation.update');
        Route::post('/superadmin/designation/update',[DesgnationController::class,'update'])->name('superadmin.designation.update');
        Route::delete('/superadmin/designation/delete/{id}',[DesgnationController::class,'delete'])->name('superadmin.designation.delete');

        // Role Management 
        Route::get('/superadmin/role',[AdminRoleController::class,'index'])->name('superadmin.role');
        Route::get('/superadmin/role/add',[AdminRoleController::class,'add'])->name('superadmin.role.add');
        Route::post('/superadmin/role/insert',[AdminRoleController::class,'insert'])->name('superadmin.role.insert');
        Route::get('/superadmin/role/edit/{id}',[AdminRoleController::class,'edit'])->name('superadmin.role.edit');
        Route::post('/superadmin/role/update',[AdminRoleController::class,'update'])->name('superadmin.role.update');
        Route::get('/superadmin/role/view/{id}',[AdminRoleController::class,'view'])->name('superadmin.role.view');
        Route::delete('/superadmin/role/delete/{id}',[AdminRoleController::class,'delete'])->name('superadmin.role.delete');
        
        // Leave Application status
        Route::get('/superadmin/leave',[SuperAdminLeaveController::class,'index'])->name('superadmin.leave');
        Route::get('/superadmin/leave/view/{slug}',[SuperAdminLeaveController::class,'view'])->name('superadmin.leave.view');
        Route::post('/superadmin/leave/update',[SuperAdminLeaveController::class,'update'])->name('superadmin.leave.update');
        Route::delete('/superadmin/leave/delete/{slug}',[SuperAdminLeaveController::class,'delete'])->name('superadmin.leave.view');
        
        // Leave Application status
        Route::get('/superadmin/dailyreport',[AdminDailyReportController::class,'index'])->name('superadmin.dailyreport');
        Route::get('/superadmin/dailyreport/view/{slug}',[AdminDailyReportController::class,'view'])->name('superadmin.dailyreport.view');
        Route::post('/superadmin/dailyreport/update',[AdminDailyReportController::class,'update'])->name('superadmin.dailyreport.update');
        Route::post('/superadmin/dailyreport/softdelete',[AdminDailyReportController::class,'softDelete'])->name('superadmin.dailyreport.softdelete');
        Route::get('/superadmin/dailyreport/searchname',[AdminDailyReportController::class,'searchName'])->name('superadmin.dailyreport.searchname');
        
        // Leave Setting status
        Route::get('/superadmin/leavesetting',[LeaveSettingController::class,'index'])->name('superadmin.leavesetting');
        Route::post('/superadmin/leavesetting/update',[LeaveSettingController::class,'update'])->name('superadmin.leavesetting.update');

        //SuperAdmin Basic Controller
        Route::get('/superadmin/basic',[BasicController::class,'index'])->name('superadmin.basic');
        Route::post('/superadmin/basic/update',[BasicController::class,'update'])->name('superadmin.basic.update');
        // 404 for not authrized
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
