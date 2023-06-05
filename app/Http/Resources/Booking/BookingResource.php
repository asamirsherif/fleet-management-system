<?php

namespace App\Http\Resources\Booking;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Trip\TripUserResource;
use App\Models\Trip\TripUser;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'tripUserData' => new TripUserResource(TripUser::find($this->trip_user_id))
        ];
    }
}
