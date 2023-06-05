<?php

namespace App\Http\Resources\V1\Vehicle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ulid' => $this->ulid,
            'vehicle' => new VehicleResource($this->vehicle),
            'seatName' => $this->name,
        ];
    }
}
