<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use BookingScope;
    use BookingRelation;

    protected $fillable = ['user_id', 'seat_id','start_station_id','end_station_id','price'];
}
