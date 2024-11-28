<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Shift;

class EmployeeController extends Controller
{
    public function schedule(Request $request)
    {

        $employee = Employee::where('api_token', $request->bearerToken())->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.',
            ], 404);
        }
        // $employee = $request->user(); // الموظف المصادق عليه

        // استرجاع جدول الورديات الخاص بالموظف
        $shifts = Shift::where('zone_id', $employee->zone_id)
            ->whereBetween('start_date', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $shifts,
        ]);
    }
}
