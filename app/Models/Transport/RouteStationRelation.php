<?php

namespace App\Models\Transport;

use App\Models\Transport\Route;
use App\Models\Station\Station;

trait RouteStationRelation {

    public function route()
    {
        return $this->belongsToMany(Route::class, 'routes');
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function startStation()
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }

    public function endStation()
    {
        return $this->belongsTo(Station::class, 'end_station_id');
    }

}
