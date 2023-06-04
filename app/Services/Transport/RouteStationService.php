<?php

namespace App\Services\Transport;

use App\Models\Transport\RouteStation;
use App\Models\Transport\Route;
use Orchid\Platform\Models\Role;

class RouteStationService
{
    public function createRouteStation(int $routeId, array $data)
    {
        $route = Route::find($routeId);
        $routeStations = $this->routeStationData($routeId, $data);

        return $route->routeStations()->attach($routeStations);
    }


    public function matrixEditData(int $routeId) : array
    {
        $route = Route::with('routeStation')->find($routeId);
        $routeStations = $route->routeStation;
        $routeStationData = [];

        foreach ($routeStations as $key => $station) {
            $routeStationData[++$key] = [
                "ID"              => $station->id,
                "Start Station"   => $station->start_station_id,
                "End Station"     => $station->end_station_id,
                "Price"           => $station->price
            ];
        }

        return $routeStationData;
    }

    public function getRouteStation(int $id): ?RouteStation
    {
        return RouteStation::find($id);
    }


    //refactor later ( sync method was buggy and frontend needed changes )
    public function updateRouteStation(int $routeId, array $data)
    {
        $route = Route::find($routeId);
        $routeStations = $this->routeStationData($routeId, $data);
        $idsArray = [];
        $routeStationIds = $route->routeStation->pluck('id')->toArray();

        foreach($routeStations as $routeStation){
            if(isset($routeStation['id'])){
                $routeStationModel = RouteStation::find($routeStation['id']);
                $routeStationModel->update($routeStation);
                $idsArray[] = $routeStation['id'];
            } else {
                RouteStation::create($routeStation);
            }
        }

        // we won't be deleting route stations in this demo
    }

    public function deleteRouteStation(int $id): bool
    {
        return RouteStation::destroy($id) > 0;
    }

    public function routeStationData($routeId,$data){
        $routeStationData = collect($data)->map(function ($routeStationData,$key) use ($routeId) {

            if($routeStationData['ID'])
                $routeStationData['id'] = $routeStationData['ID'];

            $routeStationData['start_station_id']   = $routeStationData['Start Station'];
            $routeStationData['end_station_id']     = $routeStationData['End Station'];
            $routeStationData['price']              = $routeStationData['Price'];
            $routeStationData['route_id']           = $routeId;
            $routeStationData['order']              = $key;

            unset($routeStationData['Start Station']);
            unset($routeStationData['End Station']);
            unset($routeStationData['Price']);
            unset($routeStationData['ID']);

            return $routeStationData;
        });

        return $routeStationData->toArray();
    }
}
