<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class EmployeeAuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $employee = Employee::where('mobile_number', $request->phone)->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Cache OTP with expiration (5 minutes)
        Cache::put('otp_' . $employee->id, $otp, now()->addMinutes(5));

        // Send OTP via SMS
        $message = "Your OTP code is: $otp";
        $this->otpService->sendOtp($request->phone, $message);

        return response()->json([
            'message' => 'OTP sent successfully',
            'employee_id' => $employee->id, // لاستخدامه عند التحقق
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'otp' => 'required|integer',
        ]);

        // Check OTP from cache
        $cachedOtp = Cache::get('otp_' . $request->employee_id);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }

        $employee = Employee::find($request->employee_id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        // Generate remember token
        $rememberToken = Str::random(60);
        $employee->forceFill(['remember_token' => $rememberToken])->save();

        // Clear OTP from cache
        Cache::forget('otp_' . $request->employee_id);

        return response()->json([
            'message' => 'OTP verified successfully',
            'employee' => [
                'id' => $employee->id,
                'name' => $employee->first_name . ' ' . $employee->family_name,
                'remember_token' => $rememberToken,
            ],
        ]);
    }
}
