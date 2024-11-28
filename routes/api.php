<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployeeAuthController;

use App\Http\Controllers\EmployeeController;






Route::post('/employee/login', [EmployeeAuthController::class, 'login']);
Route::post('/employee/verify-otp', [EmployeeAuthController::class, 'verifyOtp']);



Route::middleware('auth:employee')->group(function () {
    Route::get('employee/schedule', [EmployeeController::class, 'schedule']);
});



















Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function (Request $request) {   
    return response()->json(
        [
            'status' => 'success',
            'message' => 'test'
        ]   
    );
});
