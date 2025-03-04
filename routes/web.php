<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

// For Employe Controller 
use App\Http\Controllers\Employe\DashboardController;
use App\Http\Controllers\Employe\RoleController;
use App\Http\Controllers\Employe\LeaveFormController;
use App\Http\Controllers\Employe\EarlyLeaveController;
use App\Http\Controllers\Employe\DailyReportController;
use App\Http\Controllers\Employe\EmployeController; 

use App\Http\Controllers\Employe\EmployeLoginController;

// Super Admin Dashboard
use App\Http\Controllers\SuperAdmin\AdminProfileController;
use App\Http\Controllers\SuperAdmin\SuperAdminController; 
use App\Http\Controllers\SuperAdmin\AdminEmployeController; 
use App\Http\Controllers\SuperAdmin\EmployeePromotionController; 
use App\Http\Controllers\SuperAdmin\EmployeeEvaluationController; 
use App\Http\Controllers\SuperAdmin\BasicController;
use App\Http\Controllers\SuperAdmin\DesgnationController; 
use App\Http\Controllers\SuperAdmin\SuperAdminLeaveController; 
use App\Http\Controllers\SuperAdmin\AdminEarlyLeaveController; 
use App\Http\Controllers\SuperAdmin\AdminDailyReportController; 

use App\Http\Controllers\SuperAdmin\LeaveSettingController; 
use App\Http\Controllers\SuperAdmin\TimeZoneController; 
use App\Http\Controllers\SuperAdmin\LeaveTypeController; 
use App\Http\Controllers\SuperAdmin\OfficeBranchController; 
use App\Http\Controllers\SuperAdmin\BankNameController; 
use App\Http\Controllers\SuperAdmin\BankBranchController; 
use App\Http\Controllers\SuperAdmin\DepartmentController; 
use App\Http\Controllers\SuperAdmin\CateringFoodController; 
use App\Http\Controllers\SuperAdmin\CateringPaymentController; 
use App\Http\Controllers\SuperAdmin\AdminEmailController; 

use App\Http\Controllers\SuperAdmin\RecyclebinController; 

use App\Http\Controllers\SuperAdmin\AdminRoleController; 
use App\Http\Controllers\SuperAdmin\PermissionController; 


Route::get('/', function () {
    return view('welcome');
})->name('.');


// ========= Employe Dashboard
Route::middleware('isEmploye')->group(function(){
       Route::middleware('isEmployeActive')->group(function(){
     
         Route::get('/dashboard/employe',[EmployeController::class,'index'])->name('dashboard.employe');
         Route::get('/dashboard/employe/view/{slug}',[EmployeController::class,'view'])->name('dashboard.employe.view');
         // Route::get('/dashboard/employe/edit/{slug}',[EmployeController::class,'edit'])->name('dashboard.employe.edit');
         // Route::post('/dashboard/employe/update',[EmployeController::class,'update'])->name('dashboard.employe.update');
         Route::get('/dashboard/employe/profileSettings/{slug}',[EmployeController::class,'profileSettings'])->name('dashboard.employe.profileSettings');
         Route::post('/dashboard/employe/profileSettingUpdate',[EmployeController::class,'profileSettingUpdate'])->name('dashboard.employe.profileSettingUpdate');
       });

});


// remove notifuication
Route::post('/notificationAdmin/remove/{id}',[SuperAdminLeaveController::class,'removeNotification']);
// Super Admin Dashboard

Route::middleware(['auth','verified'])->group(function(){
    Route::middleware('isEmployeActive')->group(function(){
                 Route::get('/portal',[SuperAdminController::class,'dashboard'])->name('portal');

                Route::get('/portal/recycle',[RecyclebinController::class,'dashboard'])->name('portal.recycle');
                Route::get('/portal/recycle/employe',[RecyclebinController::class,'employe'])->name('portal.recycle.employe');
                Route::get('/portal/recycle/dailyreport',[RecyclebinController::class,'dailyreport'])->name('portal.recycle.dailyreport');
                // Add Admin 
                Route::get('portal/admin/add',[AdminProfileController::class,'add'])->name('portal.admin.add');
         
                // Admin Profile Controller 
                Route::get('portal/admin',[AdminProfileController::class,'index'])->name('portal.admin');
                Route::post('portal/admin/insert',[AdminProfileController::class,'insert'])->name('portal.admin.insert');
                Route::get('portal/view/profile/{id}',[AdminProfileController::class,'viewProfile'])->name('portal.view.profile');
                Route::get('portal/profile/{slug}',[AdminProfileController::class,'profileAdmin'])->name('portal.profile');
                Route::post('portal/profile/update',[AdminProfileController::class,'updateAdmin'])->name('portal.profile.update');
                Route::post('portal/view/softdelete',[AdminProfileController::class,'softDelete'])->name('portal.view.softdelete');
                Route::post('portal/restore',[AdminProfileController::class,'restore'])->name('portal.restore');
                Route::delete('admin/delete',[AdminProfileController::class,'delete'])->name('admin.delete');
                // Admin Edit Access 
                // Route::get('/dashboard/admin/edit/{slug}',[AdminController::class,'edit'])->name('dashboard.admin.edit');
                // Route::delete('/dashboard/admin/delete/{slug}',[AdminController::class,'delete'])->name('dashboard.admin.view');
                
                // Add Employer Controller
                Route::get('/portal/employe',[AdminEmployeController::class,'index'])->name('portal.employe');
                Route::get('/portal/employe/add',[AdminEmployeController::class,'add'])->name('portal.employe.add');
                Route::post('/portal/employe/insert',[AdminEmployeController::class,'insert'])->name('portal.employe.insert');
                Route::get('/portal/employe/edit/{slug}',[AdminEmployeController::class,'edit'])->name('portal.employe.edit');
                Route::post('/portal/employe/update',[AdminEmployeController::class,'update'])->name('portal.employe.update');
                Route::post('/portal/employe/softdelete',[AdminEmployeController::class,'softdele'])->name('portal.employe.softdelete');
                Route::post('/portal/employe/restore',[AdminEmployeController::class,'restore'])->name('portal.employe.restore');
                Route::get('/portal/employe/view/{slug}',[AdminEmployeController::class,'view'])->name('portal.employe.view');
                Route::delete('/portal/employe/delete',[AdminEmployeController::class,'delete'])->name('portal.employe.delete');

                // my Profile
                Route::get('/portal/employe/profile/{slug}',[AdminEmployeController::class,'profileView'])->name('portal.employe.profile');
                Route::get('/portal/employe/editprofile/{slug}',[AdminEmployeController::class,'profileEdit'])->name('portal.employe.editprofile');
                Route::post('/portal/employe/updateprofile',[AdminEmployeController::class,'profileUpdate'])->name('portal.employe.updateprofile');
                // log in as a employee
                Route::post('/portal/employe/login/{id}',[AdminEmployeController::class,'login'])->name('portal.employe.login');
               
                // get data from select

                Route::get('/get_designation/{id}',[DesgnationController::class,'getDesignation']);
                Route::get('/get_bankBranch/{id}',[BankBranchController::class,'getBankBranch']);

                // Employee Evaluation
                Route::get('/admin/evaluation/{id}',[EmployeeEvaluationController::class,'index'])->name('admin.evaluation');
                Route::get('/admin/evaluation/add',[EmployeeEvaluationController::class,'add'])->name('admin.evaluation.add');
                Route::post('/admin/evaluation/insert',[EmployeeEvaluationController::class,'insert'])->name('admin.evaluation.insert');
                Route::get('/admin/evaluation/edit/{id}',[EmployeeEvaluationController::class,'edit'])->name('admin.evaluation.edit');
                Route::post('/admin/evaluation/update',[EmployeeEvaluationController::class,'update'])->name('admin.evaluation.update');
                Route::post('/admin/evaluation/softdelete',[EmployeeEvaluationController::class,'softdele'])->name('admin.evaluation.softdelete');
                Route::post('/admin/evaluation/restore',[EmployeeEvaluationController::class,'restore'])->name('admin.evaluation.restore');
                Route::get('/admin/evaluation/view/{slug}',[EmployeeEvaluationController::class,'view'])->name('admin.evaluation.view');
                Route::delete('/admin/evaluation/delete',[EmployeeEvaluationController::class,'delete'])->name('admin.evaluation.delete');
                // Employee Promotion
                Route::get('/admin/promotion/{id}',[EmployeePromotionController::class,'index'])->name('admin.promotion');
                Route::get('/admin/promotion/add',[EmployeePromotionController::class,'add'])->name('admin.promotion.add');
                Route::post('/admin/promotion/insert',[EmployeePromotionController::class,'insert'])->name('admin.promotion.insert');
                Route::get('/admin/promotion/edit/{id}',[EmployeePromotionController::class,'edit'])->name('admin.promotion.edit');
                Route::post('/admin/promotion/update',[EmployeePromotionController::class,'update'])->name('admin.promotion.update');
                Route::post('/admin/promotion/softdelete',[EmployeePromotionController::class,'softdele'])->name('admin.promotion.softdelete');
                Route::post('/admin/promotion/restore',[EmployeePromotionController::class,'restore'])->name('admin.promotion.restore');
                Route::get('/admin/promotion/view/{slug}',[EmployeePromotionController::class,'view'])->name('admin.promotion.view');
                Route::delete('/admin/promotion/delete',[EmployeePromotionController::class,'delete'])->name('admin.promotion.delete');

                // Designation Controller
                Route::get('/portal/designation',[DesgnationController::class,'index'])->name('portal.designation');
                Route::get('/portal/designation/add',[DesgnationController::class,'add'])->name('portal.designation.add');
                Route::post('/portal/designation/insert',[DesgnationController::class,'insert'])->name('portal.designation.insert');
                Route::get('/portal/designation/view/{id}',[DesgnationController::class,'view'])->name('portal.designation.view');
                Route::get('/portal/designation/edit/{id}',[DesgnationController::class,'edit'])->name('portal.designation.edit');
                Route::post('/portal/designation/update',[DesgnationController::class,'update'])->name('portal.designation.update');
                Route::delete('/portal/designation/delete',[DesgnationController::class,'delete'])->name('portal.designation.delete');

                // Office Branch 
                Route::get('/portal/office_branch',[OfficeBranchController::class,'index'])->name('portal.office_branch');
                Route::get('/portal/office_branch/add',[OfficeBranchController::class,'add'])->name('portal.office_branch.add');
                Route::post('/portal/office_branch/insert',[OfficeBranchController::class,'insert'])->name('portal.office_branch.insert');
                Route::get('/portal/office_branch/edit/{id}',[OfficeBranchController::class,'edit'])->name('portal.office_branch.edit');
                Route::post('/portal/office_branch/update',[OfficeBranchController::class,'update'])->name('portal.office_branch.update');
                Route::get('/portal/office_branch/view/{id}',[OfficeBranchController::class,'view'])->name('portal.office_branch.view');
                Route::delete('/portal/office_branch/delete',[OfficeBranchController::class,'delete'])->name('portal.office_branch.delete');
            
                // Bank Detail
                Route::get('/portal/bank_name',[BankNameController::class,'index'])->name('portal.bank_name');
                Route::get('/portal/bank_name/add',[BankNameController::class,'add'])->name('portal.bank_name.add');
                Route::post('/portal/bank_name/insert',[BankNameController::class,'insert'])->name('portal.bank_name.insert');
                Route::get('/portal/bank_name/edit/{id}',[BankNameController::class,'edit'])->name('portal.bank_name.edit');
                Route::post('/portal/bank_name/update',[BankNameController::class,'update'])->name('portal.bank_name.update');
                Route::get('/portal/bank_name/view/{id}',[BankNameController::class,'view'])->name('portal.bank_name.view');
                Route::delete('/portal/bank_name/delete',[BankNameController::class,'delete'])->name('portal.bank_name.delete');
                
                // Bank Branch
                Route::get('/portal/bank_branch',[BankBranchController::class,'index'])->name('portal.bank_branch');
                Route::get('/portal/bank_branch/add',[BankBranchController::class,'add'])->name('portal.bank_branch.add');
                Route::post('/portal/bank_branch/insert',[BankBranchController::class,'insert'])->name('portal.bank_branch.insert');
                Route::get('/portal/bank_branch/edit/{id}',[BankBranchController::class,'edit'])->name('portal.bank_branch.edit');
                Route::post('/portal/bank_branch/update',[BankBranchController::class,'update'])->name('portal.bank_branch.update');
                Route::get('/portal/bank_branch/view/{id}',[BankBranchController::class,'view'])->name('portal.bank_branch.view');
                Route::delete('/portal/bank_branch/delete',[BankBranchController::class,'delete'])->name('portal.bank_branch.delete');
            
                // Department
                Route::get('/portal/department',[DepartmentController::class,'index'])->name('portal.department');
                Route::get('/portal/department/add',[DepartmentController::class,'add'])->name('portal.department.add');
                Route::post('/portal/department/insert',[DepartmentController::class,'insert'])->name('portal.department.insert');
                Route::get('/portal/department/edit/{id}',[DepartmentController::class,'edit'])->name('portal.department.edit');
                Route::post('/portal/department/update',[DepartmentController::class,'update'])->name('portal.department.update');
                Route::get('/portal/department/view/{id}',[DepartmentController::class,'view'])->name('portal.department.view');
                Route::delete('/portal/department/delete',[DepartmentController::class,'delete'])->name('portal.department.delete');

                // Leave Management 
                Route::get('/portal/leavetype',[LeaveTypeController::class,'index'])->name('portal.leavetype');
                Route::get('/portal/leavetype/add',[LeaveTypeController::class,'add'])->name('portal.leavetype.add');
                Route::post('/portal/leavetype/insert',[LeaveTypeController::class,'insert'])->name('portal.leavetype.insert');
                Route::get('/portal/leavetype/edit/{id}',[LeaveTypeController::class,'edit'])->name('portal.leavetype.edit');
                Route::post('/portal/leavetype/update',[LeaveTypeController::class,'update'])->name('portal.leavetype.update');
                Route::get('/portal/leavetype/view/{id}',[LeaveTypeController::class,'view'])->name('portal.leavetype.view');
                Route::delete('/portal/leavetype/delete/',[LeaveTypeController::class,'delete'])->name('portal.leavetype.delete');
                
                // Leave Application status
                Route::get('/portal/leave/add',[SuperAdminLeaveController::class,'add'])->name('portal.leave.add');
                Route::post('/portal/leave/insert',[SuperAdminLeaveController::class,'insert'])->name('portal.leave.insert');
                Route::get('/portal/leave/edit/{id}',[SuperAdminLeaveController::class,'edit'])->name('portal.leave.edit');
                Route::post('/portal/leave/updateleave',[SuperAdminLeaveController::class,'updateleave'])->name('portal.leave.updateleave');
                Route::get('/portal/leave',[SuperAdminLeaveController::class,'index'])->name('portal.leave');
                Route::get('/portal/leavemonth/{slug}',[SuperAdminLeaveController::class,'indexMonth'])->name('portal.leaveMonth');
                Route::get('/portal/leaveYear/{slug}',[SuperAdminLeaveController::class,'indexYear'])->name('portal.leaveYear');
                Route::get('/portal/leave/pending',[SuperAdminLeaveController::class,'pending'])->name('portal.leave.pending');
                Route::get('/portal/leave/approved',[SuperAdminLeaveController::class,'approved'])->name('portal.leave.approved');
                Route::get('/portal/leave/cancled',[SuperAdminLeaveController::class,'cancled'])->name('portal.leave.cancled');
                Route::get('/portal/leave/view/{slug}',[SuperAdminLeaveController::class,'view'])->name('portal.leave.view');
                Route::post('/portal/leave/update',[SuperAdminLeaveController::class,'update'])->name('portal.leave.update');
                Route::post('/portal/leave/softdelete',[SuperAdminLeaveController::class,'softDelete'])->name('portal.leave.softdelete');
                Route::post('/portal/leave/restore',[SuperAdminLeaveController::class,'restore'])->name('portal.leave.restore');
                Route::delete('/portal/leave/delete/',[SuperAdminLeaveController::class,'delete'])->name('portal.leave.delete');
                
                // Leave Application status
                
                Route::get('/admin/earlyleave',[AdminEarlyLeaveController::class,'index'])->name('admin.earlyleave');
                Route::get('/admin/earlyleave/view/{slug}',[AdminEarlyLeaveController::class,'view'])->name('admin.earlyleave.view');
                Route::get('/admin/earlyleave/add',[AdminEarlyLeaveController::class,'add'])->name('admin.earlyleave.add');
                Route::post('/admin/earlyleave/insert',[AdminEarlyLeaveController::class,'insert'])->name('admin.earlyleave.insert');
                Route::get('/admin/earlyleave/edit/{id}',[AdminEarlyLeaveController::class,'edit'])->name('admin.earlyleave.edit');
                Route::get('/admin/earlyleave/update/{id}',[AdminEarlyLeaveController::class,'update'])->name('admin.earlyleave.update');
                Route::post('/admin/earlyleave/updateleave',[AdminEarlyLeaveController::class,'updateleave'])->name('admin.earlyleave.updateleave');
                Route::get('/admin/earlyleavemonth/{slug}',[AdminEarlyLeaveController::class,'indexMonth'])->name('admin.earlyleavemonth');
                Route::get('/admin/earlyleaveyear/{slug}',[AdminEarlyLeaveController::class,'indexYear'])->name('admin.earlyleaveyear');
                Route::get('/admin/earlyleave/pending',[AdminEarlyLeaveController::class,'pending'])->name('admin.earlyleave.pending');
                Route::get('/admin/earlyleave/approved',[AdminEarlyLeaveController::class,'approved'])->name('admin.earlyleave.approved');
                Route::get('/admin/earlyleave/cancled',[AdminEarlyLeaveController::class,'cancled'])->name('admin.earlyleave.cancled');
                
                Route::post('/admin/earlyleave/update',[AdminEarlyLeaveController::class,'update'])->name('admin.earlyleave.update');
                Route::post('/admin/earlyleave/softdelete',[AdminEarlyLeaveController::class,'softDelete'])->name('admin.earlyleave.softdelete');
                Route::post('/admin/earlyleave/restore',[AdminEarlyLeaveController::class,'restore'])->name('admin.earlyleave.restore');
                Route::delete('/admin/earlyleave/delete/',[AdminEarlyLeaveController::class,'delete'])->name('admin.earlyleave.delete');
                
                // remove notifuication
                Route::delete('/notificationAdmin/remove/{id}',[SuperAdminLeaveController::class,'removeNotification']);
                // Daily reports 
                Route::get('/portal/dailyreport',[AdminDailyReportController::class,'index'])->name('portal.dailyreport');
                Route::get('/portal/dailyreport/view/{slug}',[AdminDailyReportController::class,'view'])->name('portal.dailyreport.view');
                Route::post('/portal/dailyreport/update',[AdminDailyReportController::class,'update'])->name('portal.dailyreport.update');
                Route::post('/portal/dailyreport/softdelete',[AdminDailyReportController::class,'softDelete'])->name('portal.dailyreport.softdelete');
                Route::post('/portal/dailyreport/restore',[AdminDailyReportController::class,'restore'])->name('portal.dailyreport.restore');
                Route::delete('/portal/dailyreport/delete',[AdminDailyReportController::class,'delete'])->name('portal.dailyreport.delete');
                Route::get('/portal/dailyreport/search/{year}/{month}/{name}',[AdminDailyReportController::class,'allSearch'])->name('portal.dailyreport.search');
                
                // Leave Setting status
                Route::get('/portal/leavesetting',[LeaveSettingController::class,'index'])->name('portal.leavesetting');
                Route::post('/portal/leavesetting/update',[LeaveSettingController::class,'update'])->name('portal.leavesetting.update');

                //SuperAdmin Basic Controller
                Route::get('/portal/basic',[BasicController::class,'index'])->name('portal.basic');
                Route::post('/portal/basic/update',[BasicController::class,'updateBasic'])->name('portal.basic.update');
                Route::post('/portal/basic/currency',[BasicController::class,'updateCurrency'])->name('portal.basic.currency');
                Route::post('/portal/basic/time',[BasicController::class,'updateTimeZone'])->name('portal.basic.time');
                Route::post('/portal/basic/officetime',[BasicController::class,'updateOfficeTime'])->name('portal.basic.officetime');

                //Email  Controller
                Route::get('/portal/email',[AdminEmailController::class,'index'])->name('portal.email');
                Route::post('/portal/email/update',[AdminEmailController::class,'update'])->name('portal.email.update');

                Route::post('/portal/activeDailyReportMail',[AdminEmailController::class,'dailyReportMailActive'])->name('portal.activeDailyReportMail');
                Route::post('/portal/activeDailyLeaveMail',[AdminEmailController::class,'dailyLeaveMailActive'])->name('portal.activeDailyLeaveMail');
                Route::post('/portal/activeDailySummaryMail',[AdminEmailController::class,'dailySummaryMailActive'])->name('portal.activeDailySummaryMail');
                Route::post('/portal/activeDeleteReport',[AdminEmailController::class,'deleteReport'])->name('portal.activeDeleteReport');

                // Role Permission Management
                // Permission Management
                Route::get('/portal/permission',[PermissionController::class,'index'])->name('portal.permission');
                Route::get('/portal/permission/add',[PermissionController::class,'add'])->name('portal.permission.add');
                Route::post('/portal/permission/insert',[PermissionController::class,'insert'])->name('portal.permission.insert');
                Route::get('/portal/permission/edit/{id}',[PermissionController::class,'edit'])->name('portal.permission.edit');
                Route::post('/portal/permission/update',[PermissionController::class,'update'])->name('portal.permission.update');
                Route::get('/portal/permission/view/{id}',[PermissionController::class,'view'])->name('portal.permission.view');
                Route::delete('/portal/permission/delete',[PermissionController::class,'delete'])->name('portal.permission.delete');
 
                // Role Management 
                Route::get('/portal/role',[AdminRoleController::class,'index'])->name('portal.role');
                Route::get('/portal/role/add',[AdminRoleController::class,'add'])->name('portal.role.add');
                Route::post('/portal/role/insert',[AdminRoleController::class,'insert'])->name('portal.role.insert');
                Route::get('/portal/role/edit/{id}',[AdminRoleController::class,'edit'])->name('portal.role.edit');
                Route::post('/portal/role/update',[AdminRoleController::class,'update'])->name('portal.role.update');
                Route::get('/portal/role/view/{id}',[AdminRoleController::class,'view'])->name('portal.role.view');
                Route::delete('/portal/role/delete',[AdminRoleController::class,'delete'])->name('portal.role.delete');
                
   
                // Catering Food
                Route::get('/portal/cateringfood',[CateringFoodController::class,'index'])->name('portal.cateringfood');
                Route::get('/portal/cateringfood/add',[CateringFoodController::class,'add'])->name('portal.cateringfood.add');
                Route::post('/portal/cateringfood/insert',[CateringFoodController::class,'insert'])->name('portal.cateringfood.insert');
                Route::get('/portal/cateringfood/view/{id}',[CateringFoodController::class,'view'])->name('portal.cateringfood.view');
                Route::get('/portal/cateringfood/edit/{id}',[CateringFoodController::class,'edit'])->name('portal.cateringfood.edit');
                Route::post('/portal/cateringfood/update',[CateringFoodController::class,'update'])->name('portal.cateringfood.update');
                Route::delete('/portal/cateringfood/delete',[CateringFoodController::class,'delete'])->name('portal.cateringfood.delete');
                
                // Catering Payment
                Route::get('/portal/cateringpayment',[CateringPaymentController::class,'index'])->name('portal.cateringpayment');
                Route::get('/portal/cateringpayment/checkbill',[CateringPaymentController::class,'checkBill'])->name('portal.cateringpayment.checkbill');
                Route::get('/portal/cateringpayment/add',[CateringPaymentController::class,'add'])->name('portal.cateringpayment.add');
                Route::post('/portal/cateringpayment/insert',[CateringPaymentController::class,'insert'])->name('portal.cateringpayment.insert');
                Route::get('/portal/cateringpayment/view/{id}',[CateringPaymentController::class,'view'])->name('portal.cateringpayment.view');
                Route::get('/portal/cateringpayment/edit/{id}',[CateringPaymentController::class,'edit'])->name('portal.cateringpayment.edit');
                Route::post('/portal/cateringpayment/update',[CateringPaymentController::class,'update'])->name('portal.cateringpayment.update');
                Route::delete('/portal/cateringpayment/delete',[CateringPaymentController::class,'delete'])->name('portal.cateringpayment.delete');

                // Search by month
                Route::get('/portal/cateringfood/{month}',[CateringFoodController::class,'searchMonth']);
                Route::get('/portal/cateringfood/year/{month}',[CateringFoodController::class,'searchYear']);
                // Search by month Payment
                Route::get('/portal/cateringpayment/{month}',[CateringPaymentController::class,'searchMonth']);
                Route::get('/portal/cateringpayment/year/{year}',[CateringPaymentController::class,'searchYear']);

                 // Work Like Employeee data

                // Dsahboard Index
                Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
                // Leave Application for Employee
                Route::get('/dashboard/leave/add',[LeaveFormController::class,'add'])->name('dashboard.leave.add');
                Route::post('/dashboard/leave/insert',[LeaveFormController::class,'insert'])->name('dashboard.leave.insert');
                Route::get('/dashboard/leave/view/{slug}',[LeaveFormController::class,'view'])->name('dashboard.leave.view'); 
                Route::get('/dashboard/leave/edit/{slug}',[LeaveFormController::class,'edit'])->name('dashboard.leave.edit'); 
                Route::post('/dashboard/leave/update',[LeaveFormController::class,'update'])->name('dashboard.leave.update');
                Route::get('/dashboard/leave/history/{slug}',[LeaveFormController::class,'history'])->name('dashboard.leave.history'); 
                Route::get('/dashboard/leave/historyMonth/{slug}',[LeaveFormController::class,'historyMonth'])->name('dashboard.leave.historyMonth'); 
                Route::get('/dashboard/leave/historyYear/{slug}',[LeaveFormController::class,'historyYear'])->name('dashboard.leave.historyYear'); 
                
                // Leave Application status by General User
                Route::get('/dashboard/earlyleave/add',[EarlyLeaveController::class,'add'])->name('dashboard.earlyleave.add');
                Route::post('/dashboard/earlyleave/insert',[EarlyLeaveController::class,'insert'])->name('dashboard.earlyleave.insert');
                Route::get('/dashboard/earlyleave/view/{slug}',[EarlyLeaveController::class,'view'])->name('dashboard.earlyleave.view'); 
                Route::get('/dashboard/earlyleave/edit/{slug}',[EarlyLeaveController::class,'edit'])->name('dashboard.earlyleave.edit'); 
                Route::post('/dashboard/earlyleave/update',[EarlyLeaveController::class,'update'])->name('dashboard.earlyleave.update');
                Route::get('/dashboard/earlyleave/{slug}',[EarlyLeaveController::class,'index'])->name('dashboard.earlyleave');

                 // Employe Daily Reports Submit
                Route::get('/dashboard/dailyreport',[DailyReportController::class,'index'])->name('dashboard.dailyreport');
                Route::get('/dashboard/dailyreport/add',[DailyReportController::class,'add'])->name('dashboard.dailyreport.add');
                Route::post('/dashboard/dailyreport/submit',[DailyReportController::class,'submit'])->name('dashboard.dailyreport.submit'); 
                Route::get('/dashboard/dailyreport/edit/{slug}',[DailyReportController::class,'edit'])->name('dashboard.dailyreport.edit');
                Route::post('/dashboard/dailyreport/update',[DailyReportController::class,'update'])->name('dashboard.dailyreport.update'); 
                Route::get('/dashboard/dailyreport/view/{slug}',[DailyReportController::class,'view'])->name('dashboard.dailyreport.view'); 
        });

        Route::get('notActiveUser',function(){
            return view('employe.notActiveUser');
        })->name('notActiveUser');
    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
