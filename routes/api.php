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

Route::get('/employe',[EmployeeAuthController::class,'index'])->name('employe')->middleware('auth:sanctum');
// daily reports

Route::get('/dashboard/dailyreport',[DailyReportController::class,'index'])->name('dashboard.daiyreport');
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/employe/logout',[EmployeeAuthController::class,'logoutEmploye'])->name('employe.logout');
    
});

