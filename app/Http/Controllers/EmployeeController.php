<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Shift;

use App\Models\Project;

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

    public function getEmployeeProjects(Request $request)
    {
        $employeeId = $request->user()->id; // الحصول على الموظف الحالي من التوكن
    
        $projects = Project::whereHas('employees', function ($query) use ($employeeId) {
            $query->where('employee_id', $employeeId);
        })
        ->with([
            'zones' => function ($query) {
                $query->with(['pattern', 'shifts']);
            }
        ])
        ->get();
    
        return response()->json([
            'status' => 'success',
            'data' => $projects->map(function ($project) {
                return [
                    'project_id' => $project->id,
                    'project_name' => $project->name,
                    'description' => $project->description,
                    'area' => [
                        'id' => $project->area->id ?? null,
                        'name' => $project->area->name ?? null,
                    ],
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'zones' => $project->zones->map(function ($zone) {
                        return [
                            'zone_id' => $zone->id,
                            'zone_name' => $zone->name,
                            'start_date' => $zone->start_date,
                            'pattern' => $zone->pattern ? [
                                'pattern_id' => $zone->pattern->id,
                                'name' => $zone->pattern->name,
                                'working_days' => $zone->pattern->working_days,
                                'off_days' => $zone->pattern->off_days,
                                'hours_cat' => $zone->pattern->hours_cat,
                            ] : null,
                            'lat'=>$zone->lat,
                            'longg' =>$zone->longg,
                            'area'=>$zone->area,
                            'emp_no'=>$zone->emp_no,


                            'shifts' => $zone->shifts->map(function ($shift) {
                                return [
                                    'shift_id' => $shift->id,
                                    'name' => $shift->name,
                                    'type' => $shift->type,
                                    'morning_start' => $shift->morning_start,
                                    'morning_end' => $shift->morning_end,
                                    'evening_start' => $shift->evening_start,
                                    'evening_end' => $shift->evening_end,
                                    'early_entry_time' => $shift->early_entry_time,
                                    'last_entry_time' => $shift->last_entry_time,
                                    'early_exit_time' => $shift->early_exit_time,
                                    'last_time_out' => $shift->last_time_out,
                                    'start_date' => $shift->start_date,
                                    'status' => $shift->status,
                                ];
                            }),
                        ];
                    }),
                ];
            }),
        ]);
    }
    
}
