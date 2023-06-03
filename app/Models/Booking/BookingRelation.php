<?php

namespace App\Models\Booking;

use App\Models\User\User;
use App\Models\Vehicle\Seat;

trait BookingRelation {

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

}
