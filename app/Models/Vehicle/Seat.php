<?php

namespace App\Models\Vehicle;

use App\Models\Traits\CommonRelation;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use phpseclib3\Crypt\EC\Formats\Keys\Common;
use App\Models\Polymorphic\Status;

class Seat extends Model
{
    use SeatRelation,
        CommonRelation,
        HasUlids;

    protected $fillable = ['ulid', 'vehicle_id', 'name'];

    protected $primaryKey = 'ulid';
    public $incrementing = false;

    public function newUniqueId()
    {
        return Str::ulid()->toBase32();
    }

    public function isAvailable(){
        return $this->status->status = Status::AVAILABLE;
    }

}
