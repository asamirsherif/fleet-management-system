<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle\Vehicle;
use App\Models\Vehicle\Seat;

/**
 * Class SeatsService
 * @package App\Services
 */
class SeatsService
{

    public function __construct(private Seat $seat)
    {

    }
    /**
     * Get all seats.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSeats()
    {
        return Seat::all();
    }

    /**
     * Get a specific seat by ID.
     *
     * @param int $seatId
     * @return \App\Models\Station\Seat|null
     */
    public function getSeatById($seatId)
    {
        return Seat::find($seatId);
    }

    /**
     * Create a new seat.
     *
     * @param array $data
     * @return \App\Models\Station\Seat
     */
    public function createSeat(Vehicle $vehicle)
    {
        $seatNumber = 1;

        for( $seatCount = $vehicle->seat_count; $seatCount > 0 ; $seatCount-- )
        {
            $data[]  = [
                'ulid' => $this->seat->newUniqueId(),
                'vehicle_id' => $vehicle->id,
                'name' => $vehicle->type . '_'. $seatNumber++,
            ];
        }

        return Seat::insert($data);
    }

    /**
     * Update an existing seat.
     *
     * @param int $seatId
     * @param array $data
     * @return bool
     */
    public function updateSeat($seatId, $data)
    {
        $seat = Seat::find($seatId);

        if ($seat) {
            return $seat->update($data);
        }

        return false;
    }

    /**
     * Delete a seat.
     *
     * @param int $seatId
     * @return bool
     */
    public function deleteSeat($seatId)
    {
        $seat = Seat::find($seatId);

        if ($seat) {
            return $seat->delete();
        }

        return false;
    }
}
