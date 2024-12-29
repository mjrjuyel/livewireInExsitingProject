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
use App\Http\Controllers\SuperAdmin\SuperAdminController; // Dashboard
use App\Http\Controllers\SuperAdmin\AdminEmployeController; // Employe Management as a SuperAdmin // super Admin can Add Edit And Delete Employe.
use App\Http\Controllers\SuperAdmin\BasicController;
use App\Http\Controllers\SuperAdmin\DesgnationController; // super Admin can add more designation.
use App\Http\Controllers\SuperAdmin\SuperAdminLeaveController; // Super Admin Manage Employee Leave request.
use App\Http\Controllers\SuperAdmin\AdminDailyReportController; /// Super admin can view detail who send dailyreport.
use App\Http\Controllers\SuperAdmin\AdminRoleController; /// Role Create,View,edit,delete.
use App\Http\Controllers\SuperAdmin\LeaveSettingController; // Leave Settings .
use App\Http\Controllers\SuperAdmin\TimeZoneController; // TimeZone Settings .
use App\Http\Controllers\SuperAdmin\LeaveTypeController; // Leave Type Add, create, edit .
use App\Http\Controllers\SuperAdmin\OfficeBranchController; // Office branches Type Add, create, edit .
use App\Http\Controllers\SuperAdmin\BankNameController; // bank anme Type Add, create, edit .
use App\Http\Controllers\SuperAdmin\BankBranchController; // Bank Branches Type Add, create, edit .
use App\Http\Controllers\SuperAdmin\DepartmentController; // Bank Branches Type Add, create, edit .
use App\Http\Controllers\SuperAdmin\CateringFoodController; // Catring Food Type Add, create, edit .
use App\Http\Controllers\SuperAdmin\CateringPaymentController; // Catring Food Payment Add, create, edit .


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
        Route::get('superadmin/view/profile/{id}',[AdminProfileController::class,'viewProfile'])->name('superadmin.view.profile');

        // Admin Edit Access 
        // Route::get('/dashboard/admin/edit/{slug}',[AdminController::class,'edit'])->name('dashboard.admin.edit');
        // Route::delete('/dashboard/admin/delete/{slug}',[AdminController::class,'delete'])->name('dashboard.admin.view');
        
        // Add Employer Controller
        Route::get('/superadmin/employe',[AdminEmployeController::class,'index'])->name('superadmin.employe');
        Route::get('/superadmin/employe/add',[AdminEmployeController::class,'add'])->name('superadmin.employe.add');
        Route::post('/superadmin/employe/insert',[AdminEmployeController::class,'insert'])->name('superadmin.employe.insert');
        Route::get('/superadmin/employe/edit/{slug}',[AdminEmployeController::class,'edit'])->name('superadmin.employe.edit');
        Route::post('/superadmin/employe/update',[AdminEmployeController::class,'update'])->name('superadmin.employe.update');
        Route::post('/superadmin/employe/softdelete',[AdminEmployeController::class,'softdele'])->name('superadmin.employe.softdelete');
        Route::get('/superadmin/employe/view/{slug}',[AdminEmployeController::class,'view'])->name('superadmin.employe.view');
        Route::delete('/superadmin/employe/delete',[AdminEmployeController::class,'delete'])->name('superadmin.employe.delete');

        // get data from select
        Route::get('/get_designation/{id}',[DesgnationController::class,'getDesigantion']);
        Route::get('/get_bankBranch/{id}',[BankBranchController::class,'getBankBranch']);

        // log in as a employee
        Route::post('/superadmin/employe/login/{id}',[AdminEmployeController::class,'login'])->name('superadmin.employe.login');

        // Designation Controller
        Route::get('/superadmin/designation',[DesgnationController::class,'index'])->name('superadmin.designation');
        Route::get('/superadmin/designation/add',[DesgnationController::class,'add'])->name('superadmin.designation.add');
        Route::post('/superadmin/designation/insert',[DesgnationController::class,'insert'])->name('superadmin.designation.insert');
        Route::get('/superadmin/designation/view/{id}',[DesgnationController::class,'view'])->name('superadmin.designation.view');
        Route::get('/superadmin/designation/edit/{id}',[DesgnationController::class,'edit'])->name('superadmin.designation.edit');
        Route::post('/superadmin/designation/update',[DesgnationController::class,'update'])->name('superadmin.designation.update');
        Route::delete('/superadmin/designation/delete/{id}',[DesgnationController::class,'delete'])->name('superadmin.designation.delete');
       
        // Catering Food
        Route::get('/superadmin/cateringfood',[CateringFoodController::class,'index'])->name('superadmin.cateringfood');
        Route::get('/superadmin/cateringfood/add',[CateringFoodController::class,'add'])->name('superadmin.cateringfood.add');
        Route::post('/superadmin/cateringfood/insert',[CateringFoodController::class,'insert'])->name('superadmin.cateringfood.insert');
        Route::get('/superadmin/cateringfood/view/{id}',[CateringFoodController::class,'view'])->name('superadmin.cateringfood.view');
        Route::get('/superadmin/cateringfood/edit/{id}',[CateringFoodController::class,'edit'])->name('superadmin.cateringfood.edit');
        Route::post('/superadmin/cateringfood/update',[CateringFoodController::class,'update'])->name('superadmin.cateringfood.update');
        Route::delete('/superadmin/cateringfood/delete/{id}',[CateringFoodController::class,'delete'])->name('superadmin.cateringfood.delete');
        
        // Catering Payment
        Route::get('/superadmin/cateringpayment',[CateringPaymentController::class,'index'])->name('superadmin.cateringpayment');
        Route::get('/superadmin/cateringpayment/checkbill',[CateringPaymentController::class,'checkBill'])->name('superadmin.cateringpayment.checkbill');
        Route::get('/superadmin/cateringpayment/add',[CateringPaymentController::class,'add'])->name('superadmin.cateringpayment.add');
        Route::post('/superadmin/cateringpayment/insert',[CateringPaymentController::class,'insert'])->name('superadmin.cateringpayment.insert');
        Route::get('/superadmin/cateringpayment/view/{id}',[CateringPaymentController::class,'view'])->name('superadmin.cateringpayment.view');
        Route::get('/superadmin/cateringpayment/edit/{id}',[CateringPaymentController::class,'edit'])->name('superadmin.cateringpayment.edit');
        Route::post('/superadmin/cateringpayment/update',[CateringPaymentController::class,'update'])->name('superadmin.cateringpayment.update');
        Route::delete('/superadmin/cateringpayment/delete/{id}',[CateringPaymentController::class,'delete'])->name('superadmin.cateringpayment.delete');

        // Search by month
        Route::get('/superadmin/cateringfood/{month}',[CateringFoodController::class,'searchMonth']);

        // Role Management 
        Route::get('/superadmin/role',[AdminRoleController::class,'index'])->name('superadmin.role');
        Route::get('/superadmin/role/add',[AdminRoleController::class,'add'])->name('superadmin.role.add');
        Route::post('/superadmin/role/insert',[AdminRoleController::class,'insert'])->name('superadmin.role.insert');
        Route::get('/superadmin/role/edit/{id}',[AdminRoleController::class,'edit'])->name('superadmin.role.edit');
        Route::post('/superadmin/role/update',[AdminRoleController::class,'update'])->name('superadmin.role.update');
        Route::get('/superadmin/role/view/{id}',[AdminRoleController::class,'view'])->name('superadmin.role.view');
        Route::delete('/superadmin/role/delete/{id}',[AdminRoleController::class,'delete'])->name('superadmin.role.delete');

        // Office Branch 
        Route::get('/superadmin/office_branch',[OfficeBranchController::class,'index'])->name('superadmin.office_branch');
        Route::get('/superadmin/office_branch/add',[OfficeBranchController::class,'add'])->name('superadmin.office_branch.add');
        Route::post('/superadmin/office_branch/insert',[OfficeBranchController::class,'insert'])->name('superadmin.office_branch.insert');
        Route::get('/superadmin/office_branch/edit/{id}',[OfficeBranchController::class,'edit'])->name('superadmin.office_branch.edit');
        Route::post('/superadmin/office_branch/update',[OfficeBranchController::class,'update'])->name('superadmin.office_branch.update');
        Route::get('/superadmin/office_branch/view/{id}',[OfficeBranchController::class,'view'])->name('superadmin.office_branch.view');
        Route::delete('/superadmin/office_branch/delete/{id}',[OfficeBranchController::class,'delete'])->name('superadmin.office_branch.delete');
      
        // Bank Detail
        Route::get('/superadmin/bank_name',[BankNameController::class,'index'])->name('superadmin.bank_name');
        Route::get('/superadmin/bank_name/add',[BankNameController::class,'add'])->name('superadmin.bank_name.add');
        Route::post('/superadmin/bank_name/insert',[BankNameController::class,'insert'])->name('superadmin.bank_name.insert');
        Route::get('/superadmin/bank_name/edit/{id}',[BankNameController::class,'edit'])->name('superadmin.bank_name.edit');
        Route::post('/superadmin/bank_name/update',[BankNameController::class,'update'])->name('superadmin.bank_name.update');
        Route::get('/superadmin/bank_name/view/{id}',[BankNameController::class,'view'])->name('superadmin.bank_name.view');
        Route::delete('/superadmin/bank_name/delete/{id}',[BankNameController::class,'delete'])->name('superadmin.bank_name.delete');
        
        // Bank Branch
        Route::get('/superadmin/bank_branch',[BankBranchController::class,'index'])->name('superadmin.bank_branch');
        Route::get('/superadmin/bank_branch/add',[BankBranchController::class,'add'])->name('superadmin.bank_branch.add');
        Route::post('/superadmin/bank_branch/insert',[BankBranchController::class,'insert'])->name('superadmin.bank_branch.insert');
        Route::get('/superadmin/bank_branch/edit/{id}',[BankBranchController::class,'edit'])->name('superadmin.bank_branch.edit');
        Route::post('/superadmin/bank_branch/update',[BankBranchController::class,'update'])->name('superadmin.bank_branch.update');
        Route::get('/superadmin/bank_branch/view/{id}',[BankBranchController::class,'view'])->name('superadmin.bank_branch.view');
        Route::delete('/superadmin/bank_branch/delete/{id}',[BankBranchController::class,'delete'])->name('superadmin.bank_branch.delete');
       
        // Department
        Route::get('/superadmin/department',[DepartmentController::class,'index'])->name('superadmin.department');
        Route::get('/superadmin/department/add',[DepartmentController::class,'add'])->name('superadmin.department.add');
        Route::post('/superadmin/department/insert',[DepartmentController::class,'insert'])->name('superadmin.department.insert');
        Route::get('/superadmin/department/edit/{id}',[DepartmentController::class,'edit'])->name('superadmin.department.edit');
        Route::post('/superadmin/department/update',[DepartmentController::class,'update'])->name('superadmin.department.update');
        Route::get('/superadmin/department/view/{id}',[DepartmentController::class,'view'])->name('superadmin.department.view');
        Route::delete('/superadmin/department/delete/{id}',[DepartmentController::class,'delete'])->name('superadmin.department.delete');

        // Leave Management 
        Route::get('/superadmin/leavetype',[LeaveTypeController::class,'index'])->name('superadmin.leavetype');
        Route::get('/superadmin/leavetype/add',[LeaveTypeController::class,'add'])->name('superadmin.leavetype.add');
        Route::post('/superadmin/leavetype/insert',[LeaveTypeController::class,'insert'])->name('superadmin.leavetype.insert');
        Route::get('/superadmin/leavetype/edit/{id}',[LeaveTypeController::class,'edit'])->name('superadmin.leavetype.edit');
        Route::post('/superadmin/leavetype/update',[LeaveTypeController::class,'update'])->name('superadmin.leavetype.update');
        Route::get('/superadmin/leavetype/view/{id}',[LeaveTypeController::class,'view'])->name('superadmin.leavetype.view');
        Route::delete('/superadmin/leavetype/delete/{id}',[LeaveTypeController::class,'delete'])->name('superadmin.leavetype.delete');
        
        // Leave Application status
        Route::get('/superadmin/leave',[SuperAdminLeaveController::class,'index'])->name('superadmin.leave');
        Route::get('/superadmin/leave/pending',[SuperAdminLeaveController::class,'pending'])->name('superadmin.leave.pending');
        Route::get('/superadmin/leave/approved',[SuperAdminLeaveController::class,'approved'])->name('superadmin.leave.approved');
        Route::get('/superadmin/leave/cancled',[SuperAdminLeaveController::class,'cancled'])->name('superadmin.leave.cancled');
        Route::get('/superadmin/leave/view/{slug}',[SuperAdminLeaveController::class,'view'])->name('superadmin.leave.view');
        Route::post('/superadmin/leave/update',[SuperAdminLeaveController::class,'update'])->name('superadmin.leave.update');
        Route::delete('/superadmin/leave/delete/{slug}',[SuperAdminLeaveController::class,'delete'])->name('superadmin.leave.view');
        
        // remove notifuication
        Route::delete('/notificationAdmin/remove/{id}',[SuperAdminLeaveController::class,'removeNotification']);
        // Daily reports 
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

        //TimeZone Basic Controller
        Route::get('/superadmin/timezone',[TimeZoneController::class,'index'])->name('superadmin.timezone');
        Route::post('/superadmin/timezone/update',[TimeZoneController::class,'update'])->name('superadmin.timezone.update');
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
