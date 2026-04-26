<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
        protected $fillable = [
        'service_name',
        'description',
        'price',
        'availability',
        'last_update_by',
    ];

public function requests()
{
    return $this->hasMany(ServiceRequest::class);
}
}
