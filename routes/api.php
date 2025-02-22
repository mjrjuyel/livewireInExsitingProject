<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Api For Employee Info
use App\Http\Controllers\Api\EmployeeAuthController; 
use App\Http\Controllers\Api\DailyReportController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/employe/login',[EmployeeAuthController::class,'loginEmploye'])->name('employe.login');
// daily reports
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/employe/logout',[EmployeeAuthController::class,'logoutEmploye'])->name('employe.logout');
    //All employee 
    Route::get('/employe',[EmployeeAuthController::class,'index'])->name('employe');   

    // logged Employee All Daily Report.
    Route::get('/dashboard/dailyreport',[DailyReportController::class,'index'])->name('dashboard.daiyreport');
    Route::get('/dashboard/dailyreport/add',[DailyReportController::class,'add'])->name('dashboard.daiyreport.add');
    Route::post('/dashboard/dailyreport/submit',[DailyReportController::class,'submit'])->name('dashboard.daiyreport.submit');
    Route::post('/dashboard/dailyreport/update/{id}',[DailyReportController::class,'update'])->name('dashboard.daiyreport.update');
    Route::get('/dashboard/dailyreport/view/{id}',[DailyReportController::class,'view'])->name('dashboard.daiyreport.view');
});

