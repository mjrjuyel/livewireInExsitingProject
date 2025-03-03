<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Api For Employee Info
use App\Http\Controllers\Api\EmployeeAuthController; 
use App\Http\Controllers\Api\DailyReportController; 
use App\Http\Controllers\Api\EmployeeDashboardController; 
use App\Http\Controllers\Api\LeaveFormController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[EmployeeAuthController::class,'login'])->name('login');
// daily reports
Route::middleware(['auth:sanctum'])->group(function(){
    //All dasboard 
    Route::get('/dashboard',[EmployeeDashboardController::class,'index'])->name('dashboard');   

    // dashboard data
        Route::get('/employe',[EmployeeAuthController::class,'index'])->name('employe');   

        // logged Employee All Daily Report -------------------------------------------------------------
        Route::get('/dashboard/dailyreport',[DailyReportController::class,'index'])->name('dashboard.daiyreport');
        Route::get('/dashboard/dailyreport/add',[DailyReportController::class,'add'])->name('dashboard.daiyreport.add');
        Route::post('/dashboard/dailyreport/submit',[DailyReportController::class,'submit'])->name('dashboard.daiyreport.submit');
        Route::post('/dashboard/dailyreport/update',[DailyReportController::class,'update'])->name('dashboard.daiyreport.update');
        Route::get('/dashboard/dailyreport/view/{id}',[DailyReportController::class,'view'])->name('dashboard.daiyreport.view');


        // Leave Application for Employee -------------------------------------------------------------
        Route::get('/dashboard/leave/add',[LeaveFormController::class,'add'])->name('dashboard.leave.add');
        Route::post('/dashboard/leave/insert',[LeaveFormController::class,'insert'])->name('dashboard.leave.insert');
        Route::get('/dashboard/leave/view/{slug}',[LeaveFormController::class,'view'])->name('dashboard.leave.view'); 
        Route::get('/dashboard/leave/edit/{slug}',[LeaveFormController::class,'edit'])->name('dashboard.leave.edit'); 
        Route::post('/dashboard/leave/update',[LeaveFormController::class,'update'])->name('dashboard.leave.update');
        Route::get('/dashboard/leave/history',[LeaveFormController::class,'history'])->name('dashboard.leave.history'); 
        Route::get('/dashboard/leave/historyMonth/{slug}',[LeaveFormController::class,'historyMonth'])->name('dashboard.leave.historyMonth'); 
        Route::get('/dashboard/leave/historyYear/{slug}',[LeaveFormController::class,'historyYear'])->name('dashboard.leave.historyYear');

        // Employee Logout --------------------------------------------------------
        Route::get('/logout',[EmployeeAuthController::class,'logout'])->name('logout');
});

