<?php

namespace App\Models\Trip;

use Illuminate\Database\Eloquent\Model;

class TripStation extends Model
{
    use TripStationRelation;

    protected $fillable = ['trip_id','start_station_id','end_station_id','arrival_time','departure_time'];
}
