<?php

namespace App\Models\Transport;

use App\Models\Transport\Trip;
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
