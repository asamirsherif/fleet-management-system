<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['type','seat_count','license_plate'];

}
