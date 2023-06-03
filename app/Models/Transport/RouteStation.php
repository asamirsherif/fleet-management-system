<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class RouteStation extends Model
{
    use RouteRelation;
    protected $fillable = ['route_id', 'station_id','order','price'];

}
