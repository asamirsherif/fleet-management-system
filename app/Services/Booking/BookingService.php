<?php

namespace App\Services\Booking;

use App\Exceptions\CustomException;
use App\Models\Booking\Booking;
use App\Models\Polymorphic\Status;
use App\Models\Trip\TripStation;
use App\Models\Trip\TripUser;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Vehicle\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

/**
 * Class BookingService
 * @package App\Services
 */
class BookingService
{
    public function getAllBookings(): Collection
    {
        return Booking::all();
    }

    public function getBookingById(int $id): ?Booking
    {
        return Booking::find($id);
    }

    public function createBooking($data)
    {


        $tripStation = TripStation::find($data->trip_id);
        $vehicle = $tripStation->trip->vehicle;

        $tripUser = $this->bookSeat($vehicle,$tripStation,$data->user_id);

        $booking = Booking::create([
            'user_id' => $data->user_id,
            'trip_station_id' => $data->trip_id,
            'trip_user_id'  => $tripUser->id
        ]);

        return $booking;

    }

    public function updateBooking(int $id, array $data): ?Booking
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->update($data);
            return $booking;
        }
        return null;
    }

    public function deleteBooking(int $id): bool
    {
        $booking = Booking::find($id);
        if ($booking) {
            return $booking->delete();
        }
        return false;
    }

    public function bookSeat(Vehicle $vehicle, TripStation $tripStation, $userId){
        $availableSeat = $vehicle->seats()->isAvailable()->first();

        if(!$availableSeat) throw new CustomException('Sorry, all seats has been booked in this vehicle!',Response::HTTP_BAD_REQUEST);

        $tripUser = TripUser::create([
            'user_id' => $userId,
            'trip_stations_id' => $tripStation->id,
            'ulid' => $availableSeat->ulid
        ]);

        DB::beginTransaction();
        $status = $availableSeat->status;
        $status->setStatus(Status::BOOKED);
        $status->save();
        DB::commit();

        return $tripUser;

    }

}
