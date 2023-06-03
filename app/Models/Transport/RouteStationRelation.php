<?php

namespace App\Models\Transport;

use App\Models\Transport\Route;
use App\Models\Station\Station;

trait RouteStationRelation {

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

}
