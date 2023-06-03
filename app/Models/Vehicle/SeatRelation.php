<?php

namespace App\Models\Vehicle;

use App\Models\Vehicle\Vehicle;

trait SeatRelation{

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

}
