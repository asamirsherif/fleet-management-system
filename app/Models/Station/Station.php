<?php

namespace App\Models\Station;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;

class Station extends Model
{
    use StationRelation,
        StationScope,
        AsSource,
        Attachable,
        Filterable;

    protected $fillable = ['name', 'latitude', 'longitude', 'parent_station_id','address'];

    public function getPlaceAttribute()
    {
        return ['latitude' => $this->latitude , 'longitude' => $this->longitude, 'address' => $this->address ];
    }

}
