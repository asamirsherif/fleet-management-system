<?php

namespace App\Models\Polymorphic;

use App\Models\Vehicle\Seat;
use App\Models\Vehicle\Vehicle;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CustomException;
use App\Models\User\User;
use Carbon\Carbon;

class Status extends Model
{
    use PolymorphicRelation;

    protected $casts = [
        'content' => 'json',
    ];

    protected $fillable = [
        'object_type',
        'object_id',
        'status',
        'content',
    ];

    const BLUE = 0;
    const GREEN = 1;
    const RED = 2;
    const ORANGE = 3;
    const BLACK = 4;


    const AVAILABLE = self::GREEN;
    const BOOKED = self::BLUE;
    const DISABLED = self::RED;
    const MOVING = self::ORANGE;

    const ACTIVE = self::GREEN;
    const LOCKED = self::RED;
    const AWAIT_ACTIVATION = self::ORANGE;
    const DEACTIVATED = self::BLACK;



    const SEATS_STATUSES = [
        self::AVAILABLE,
        self::BOOKED,
        self::DISABLED,
    ];

    const VEHICLE_STATUSES = [
        self::AVAILABLE,
        self::MOVING,
        self::DISABLED,
    ];

    const STATION_STATUES = [
        self::ACTIVE,
        self::LOCKED,
    ];

    const USER_STATUSES = [
        self::ACTIVE,
        self::LOCKED,
        self::DEACTIVATED,
        self::AWAIT_ACTIVATION,
    ];


    public function setStatus($status)
    {
        $allowedStatuses = [];
        switch ($this->object_type) {
            case Seat::class:
                $allowedStatuses = self::SEATS_STATUSES;
                break;
            case Vehicle::class:
                $allowedStatuses = self::VEHICLE_STATUSES;
                break;
            case Vehicle::class:
                $allowedStatuses = self::STATION_STATUES;
                break;
            case User::class:
                $allowedStatuses = self::USER_STATUSES;
                break;
            default:
                throw new CustomException("Can't assume allowed statuses.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!in_array($status, $allowedStatuses)) throw new CustomException("Can't set status, not allowed.", Response::HTTP_INTERNAL_SERVER_ERROR);
        $this->status = $status;
        $history = $this->content['history'];
        $history[] = [
            'status' => $this->status,
            'timestamp' => Carbon::now(),
        ];
        $this->content = ['history' => $history];
    }

    public function __htmlSpanClass()
    {
        switch ($this->status) {
            case self::BLUE:
                return 'badge-light-info';
            case self::GREEN:
                return 'badge-light-success';
            case self::RED:
                return 'badge-light-danger';
            case self::ORANGE:
                return 'badge-light-warning';
            case self::BLACK:
                return 'badge-light-dark';
            default:
                throw new CustomException("Can't assume status string value.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function __toString()
    {
        return self::constToString($this->status, $this->object_type);
    }

    public static function constToString($const, $objectType = null)
    {
        switch ($const) {
            case self::ACTIVE:
                switch ($objectType) {
                    default:
                        return 'Active';
                }
            case self::AWAIT_ACTIVATION:
                switch ($objectType) {
                    default:
                        return 'Waiting Activation';
                }
            case self::DEACTIVATED:
                switch ($objectType) {
                    default:
                        return 'Deactivated';
                }
            case self::LOCKED:
                switch ($objectType) {
                    default:
                        return 'Locked';
                }
            case self::AVAILABLE:
                switch ($objectType) {
                    case Seat::class:
                        return 'Available';
                    default:
                        return 'Available';
                }
            case self::DISABLED:
                switch ($objectType) {
                    default:
                        return 'Disabled';
                }
            case self::BOOKED:
                switch ($objectType) {
                    default:
                        return 'Booked';
                }
            default:
                throw new CustomException("Can't assume status string value.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
