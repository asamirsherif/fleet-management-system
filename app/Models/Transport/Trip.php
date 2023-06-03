<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['vehicle_id', 'route_id', 'departure_time', 'arrival_time'];
}
