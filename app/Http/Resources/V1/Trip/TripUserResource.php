<?php

namespace App\Http\Resources\V1\Trip;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Vehicle\SeatResource;
use App\Models\Vehicle\Seat;

class TripUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tripUser' => $this->id,
            'seat'     => new SeatResource(Seat::find($this->ulid))
        ];
    }
}
