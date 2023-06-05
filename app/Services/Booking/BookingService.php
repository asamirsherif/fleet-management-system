<?php

namespace App\Services\Booking;

use App\Models\Booking\Booking;
use Illuminate\Database\Eloquent\Collection;

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

    public function createBooking(array $data): Booking
    {
        return Booking::create($data);
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

}
