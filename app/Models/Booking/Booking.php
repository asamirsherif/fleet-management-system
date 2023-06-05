<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use BookingScope;
    use BookingRelation;
    use HasFactory;

    protected $fillable = ['user_id', 'trip_station_id','trip_user_id'];
}
