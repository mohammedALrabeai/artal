<?php
namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getEmployeeProjects(Request $request)
    {
        $employeeId = $request->user()->id;

        $projects = Project::whereHas('employees', function ($query) use ($employeeId) {
            $query->where('employee_id', $employeeId);
        })
        ->with(['area', 'zones.pattern', 'zones.shifts'])
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }
}
