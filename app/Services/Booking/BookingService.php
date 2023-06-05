<?php

namespace App\Services\Booking;

use App\Models\Booking\Booking;
use App\Models\Polymorphic\Status;
use App\Models\Trip\TripStation;
use App\Models\Trip\TripUser;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Vehicle\Vehicle;

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
        $booking = Booking::create([
            'user_id' => $data->user_id,
            'trip_station_id' => $data->trip_id
        ]);

        $tripStation = TripStation::find($data->trip_id);
        $vehicle = $tripStation->trip->vehicle;

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

        TripUser::create(['user_id' => $userId, 'trip_station_id' => $tripStation, $availableSeat->ulid]);

        DB::beginTransaction();
        $status = $availableSeat->status;
        $status->setStatus(Status::BOOKED);
        $status->save();
        DB::commit();

        return true;

    }

}
