<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Illuminate\Support\Facades\Cache;

class Route extends Model
{
    use RouteRelation,
        AsSource,
        Attachable,
        Filterable;

    protected $fillable = ['name'];

    public function generateSubroutes()
    {
            $subroutes = [];

            $routeStations = $this->routeStation()
                ->orderBy('order')
                ->get();

            foreach ($routeStations as $key => $startStation) {
                $subroutes = $this->generateSubroutesRecursive($routeStations, $key, $startStation, $subroutes);
            }

            return $subroutes;
    }

    private function generateSubroutesRecursive($routeStations, $currentIndex, $currentSubroute, $subroutes)
    {
        $subroutes[] = $currentSubroute;

        for ($i = $currentIndex + 1; $i < count($routeStations); $i++) {
            if ($routeStations[$i]->order > $currentSubroute->order) {
                $newSubroute = clone $currentSubroute;
                $newSubroute->end_station_id = $routeStations[$i]->end_station_id;
                $newSubroute->price += $routeStations[$i]->price;
                $newSubroute->duration += $routeStations[$i]->duration;
                $subroutes = $this->generateSubroutesRecursive($routeStations, $i, $newSubroute, $subroutes);
            }
        }

        return $subroutes;
    }

    public static function getAllSubRoutes(){

        $cacheKey = 'allSubRoutes';

        return Cache::remember($cacheKey, 60, function () {
            $routes = Route::all();
            foreach($routes as $route){
                $subRoutes[] = $route->generateSubroutes();
            }

            return $subRoutes;
        });
    }

}
