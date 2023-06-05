<?php

namespace App\Models\Transport;

use App\Models\Transport\RouteStation;

trait RouteRelation {

    public function routeStations()
    {
        return $this->belongsToMany(RouteStation::class, 'route_stations','route_id','start_station_id','end_station_id');
    }

    public function routeStation()
    {
        return $this->hasMany(RouteStation::class)->orderBy('order');
    }

}
