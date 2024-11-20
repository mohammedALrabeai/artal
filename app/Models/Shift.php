<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'zone_id',
        'type',
        'morning_start',
        'morning_end',
        'evening_start',
        'evening_end',
        'early_entry_time',
        'last_entry_time',
        'early_exit_time',
        'last_time_out',
        'start_date',
        'emp_no',
        'status',
    ];

    // علاقة مع المواقع
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
