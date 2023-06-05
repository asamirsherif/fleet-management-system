<?php

namespace App\Http\Resources\Api\V1\Transport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Station\StationResource;
use App\Models\Station\Station;
use App\Http\Resources\V1\Trip\TripResource;
use App\Models\Trip\TripStation;
use Carbon\Carbon;

class SubRouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tripData = TripStation::where('start_station_id' , $this->start_station_id)
                            ->where('end_station_id' , $this->end_station_id)
                            ->where('departure_time','>',Carbon::now())->first();  // it's greater than for demo purposes

        return [
            'routeId'               => $this->route_id,
            'startStation'          => new StationResource(Station::find($this->start_station_id)),
            'endStation'            => new StationResource(Station::find($this->end_station_id)),
            'duration'              => $this->duration,
            'price'                 => $this->price,
            'tripData'              => new TripResource($tripData)
        ];
    }
}
