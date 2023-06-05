<?php

namespace App\Http\Resources\Api\V1\Transport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Station\StationResource;
use App\Models\Station\Station;

class SubRouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'routeId'               => $this->route_id,
            'startStation'          => new StationResource(Station::find($this->start_station_id)),
            'endStation'            => new StationResource(Station::find($this->end_station_id)),
            'duration'              => $this->duration,
            'price'                 => $this->price,
        ];
    }
}
