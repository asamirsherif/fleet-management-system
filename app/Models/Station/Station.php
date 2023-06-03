<?php

namespace App\Models\Station;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use StationRelation;
    use StationScope;

    protected $fillable = ['name', 'latitude', 'longitude', 'parent_station_id'];

}
