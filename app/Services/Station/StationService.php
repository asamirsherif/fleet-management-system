<?php

namespace App\Services\Station;

use App\Models\Station\Station;

/**
 * Class StationService
 * @package App\Services
 */
class StationService
{
    public function getAllStations()
    {
        return Station::all();
    }

    public function createStation($data)
    {
        return Station::create($data);
    }

    public function updateStation($id, $data)
    {
        $station = Station::findOrFail($id);
        $station->update($data);
        return $station;
    }

    public function deleteStation($id)
    {
        $station = Station::findOrFail($id);
        $station->delete();
        return true;
    }
}
