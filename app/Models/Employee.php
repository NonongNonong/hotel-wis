<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
        protected $fillable = [
        'fname',
        'lname',
        'age',
        'birthday',
        'role',
        'department',
        'mobile_num',
        'email_add',
        'hire_date',
        'status',
        'last_update_by',
    ];

    public function schedules()
{
    return $this->hasMany(EmployeeSchedule::class);
}

public function serviceRequests()
{
    return $this->hasMany(ServiceRequest::class);
}
}
