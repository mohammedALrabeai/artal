<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'father_name',
        'grandfather_name',
        'family_name',
        'birth_date',
        'national_id',
        'national_id_expiry',
        'nationality',
        'bank_account',
        'sponsor_company',
        'blood_type',
        'contract_start',
        'contract_end',
        'actual_start',
        'basic_salary',
        'living_allowance',
        'other_allowances',
        'job_status',
        'health_insurance_status',
        'health_insurance_company',
        'vacation_balance',
        'social_security',
        'social_security_code',
        'qualification',
        'specialization',
        'mobile_number',
        'phone_number',
        'region',
        'city',
        'street',
        'building_number',
        'apartment_number',
        'postal_code',
        'facebook',
        'twitter',
        'linkedin',
        'email',
        'password',
        'added_by',
        'status',
    ];

    // علاقة مع المستخدم الذي أضاف الموظف
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    public function zones()
{
    return $this->hasMany(EmployeeZone::class);
}

public function projects()
{
    return $this->belongsToMany(Project::class, 'employee_project_records')
        ->withPivot('start_date', 'end_date', 'status');
}

}
