<?php

namespace App\Models\Trip;

use App\Models\Trip\Trip;
use App\Models\Station\Station;

trait TripStationRelation {

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

}
