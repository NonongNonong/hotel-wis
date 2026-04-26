<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSchedule extends Model
{
    protected $fillable = [
        'employee_id',
        'work_date',
        'start_time',
        'end_time',
        'department',
        'created_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}