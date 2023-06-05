<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Station\Station;

class RouteStation extends Model
{
    use RouteStationRelation;

    protected $fillable = ['route_id', 'start_station_id', 'end_station_id', 'order', 'duration', 'price'];


    public function possiblePaths()
    {
        $paths = [];
        $this->generatePaths($this, $paths);
        return $paths;
    }

    private function generatePaths($currentStation, &$paths, $currentPath = [])
    {
        $currentPath[] = $currentStation;

        if (!$currentStation->endStation) {
            // Reached the last station in the route, add the current path to the paths array
            $paths[] = $currentPath;
            return;
        }

        $nextStations = self::where('route_id', $currentStation->route_id)
            ->where('start_station_id', $currentStation->endStation->id)
            ->get();

        foreach ($nextStations as $nextStation) {
            $this->generatePaths($nextStation, $paths, $currentPath);
        }
    }
}
