<?php

namespace App\Models\Transport;

use App\Models\Vehicle\Vehicle;
use App\Models\Transport\Route;
use App\Models\Transport\TripStation;

trait TripRelation {

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function tripStations()
    {
        return $this->hasMany(TripStation::class);
    }
}
