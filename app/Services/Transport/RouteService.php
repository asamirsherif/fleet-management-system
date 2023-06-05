<?php

namespace App\Services\Transport;

use App\Exceptions\CustomException;
use App\Models\Transport\Route;
use App\Models\Transport\RouteStation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use SplPriorityQueue;
use App\Models\Station\Station;

class RouteService
{
    public function createRoute(array $data): Route
    {
        return Route::create($data);
    }

    public function getRouteById(int $id): ?Route
    {
        return Route::find($id);
    }

    public function updateRoute(Route $route, array $data): bool
    {
        return $route->update($data);
    }

    public function deleteRoute(Route $route): bool
    {
        return $route->delete();
    }

    public function getAllRoutes(): array
    {
        return Route::all()->toArray();
    }

    public function getAvailableSubroutes($startStationId, $endStationId) : array
    {
        $subRoutes = Route::getAllSubRoutes();

        foreach($subRoutes as $subRoute){
            foreach($subRoute as $sub){
                if($startStationId == $sub['start_station_id'] && $endStationId == $sub['end_station_id']){
                    $availableRoutes[] = $sub;
                }
            }
        }

        return $availableRoutes ?? [];

    }
}



