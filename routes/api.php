<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Api For Employee Info
use App\Http\Controllers\Api\EmployeeAuthController; 
use App\Http\Controllers\Api\DailyReportController; 
use App\Http\Controllers\Api\EmployeeDashboardController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[EmployeeAuthController::class,'loginEmploye'])->name('login');
// daily reports
Route::middleware('auth:sanctum')->group(function(){
    //All dasboard 
    Route::get('/dashboard',[EmployeeDashboardController::class,'index'])->name('dashboard');   

    // dashboard data
    Route::get('/employe',[EmployeeAuthController::class,'index'])->name('employe');   
    // logged Employee All Daily Report.
    Route::get('/dashboard/dailyreport',[DailyReportController::class,'index'])->name('dashboard.daiyreport');
    Route::get('/dashboard/dailyreport/add',[DailyReportController::class,'add'])->name('dashboard.daiyreport.add');
    Route::post('/dashboard/dailyreport/submit',[DailyReportController::class,'submit'])->name('dashboard.daiyreport.submit');
    Route::post('/dashboard/dailyreport/update',[DailyReportController::class,'update'])->name('dashboard.daiyreport.update');
    Route::get('/dashboard/dailyreport/view/{id}',[DailyReportController::class,'view'])->name('dashboard.daiyreport.view');
    // Employee Logout
    Route::get('/logout',[EmployeeAuthController::class,'logoutEmploye'])->name('logout');
});

