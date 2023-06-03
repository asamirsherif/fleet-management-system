<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seat extends Model
{
    use SeatRelation,
        HasUlids;

    protected $fillable = ['ulid', 'vehicle_id', 'name'];

    protected $primaryKey = 'ulid';
    public $incrementing = false;

    public function newUniqueId()
    {
        return Str::ulid()->toBase32();
    }


}
