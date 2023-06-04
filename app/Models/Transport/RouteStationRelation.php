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

}
