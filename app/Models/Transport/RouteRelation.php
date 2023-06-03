<?php

namespace App\Models\Transport;

use App\Models\Transport\RouteStation;

trait RouteRelation {

    public function routeStations()
    {
        return $this->hasMany(RouteStation::class);
    }

}
