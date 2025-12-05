<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    protected $fillable = [
        'request_time',
        'response_time', 
        'temperature',
        'humidity',
        'status'
    ];

    protected $casts = [
        'request_time' => 'datetime',
        'response_time' => 'datetime',
    ];
}