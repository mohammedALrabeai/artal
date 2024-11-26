<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProjectRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'project_id',
        'start_date',
        'end_date',
        'status',
    ];

    // علاقة مع الموظف
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // علاقة مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
