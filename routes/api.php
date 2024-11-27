<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployeeAuthController;






Route::post('/employee/login', [EmployeeAuthController::class, 'login']);
Route::post('/employee/verify-otp', [EmployeeAuthController::class, 'verifyOtp']);




















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
