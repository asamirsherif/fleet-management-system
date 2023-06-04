<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class RouteStation extends Model
{
    use RouteStationRelation;

    protected $fillable = ['route_id', 'start_station_id', 'end_station_id', 'order', 'price'];

}
