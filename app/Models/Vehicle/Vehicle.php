<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;

class Vehicle extends Model
{
    use VehicleRelation,
        AsSource,
        Attachable,
        Filterable;

    protected $fillable = ['type','seat_count','license_plate'];

    const TYPES = ['Bus' => 'Bus', 'Mini Bus' => 'Mini Bus' , 'Microbus' => 'Microbus', 'Car' => 'Car', 'Van' => 'Van'];

}
