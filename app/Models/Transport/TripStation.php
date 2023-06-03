<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class TripStation extends Model
{
    protected $fillable = ['trip_id', 'station_id', 'arrival_time', 'departure_time'];
}
