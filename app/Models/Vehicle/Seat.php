<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['ulid', 'vehicle_id', 'name'];

    protected $primaryKey = 'ulid';
    public $incrementing = false;


}
