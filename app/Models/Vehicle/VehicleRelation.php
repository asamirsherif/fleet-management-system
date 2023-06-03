<?php

namespace App\Models\Vehicle;

use App\Models\Vehicle\Seat;

trait VehicleRelation {

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

}
