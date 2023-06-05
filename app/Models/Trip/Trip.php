<?php

namespace App\Models\Trip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory,
        TripRelation;

    protected $fillable = ['vehicle_id','route_id','departure_time','arrival_time'];
}
