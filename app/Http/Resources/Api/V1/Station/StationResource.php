<?php

namespace App\Http\Resources\Api\V1\Station;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,
            'isSubStation'=> $this->isSubStation()
        ];
    }
}
