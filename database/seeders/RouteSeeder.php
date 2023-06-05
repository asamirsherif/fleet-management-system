<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transport\Route;
use App\Models\Transport\RouteStation;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $routes = [
            [
                'name' => 'International Coastal Road',
                'stations' => [
                    ['start_station_id' => 1, 'end_station_id' => 2, 'order' => 1, 'duration' => '60', 'price' => 5],
                    ['start_station_id' => 2, 'end_station_id' => 3, 'order' => 2, 'duration' => '120', 'price' => 10],
                    ['start_station_id' => 4, 'end_station_id' => 5, 'order' => 3, 'duration' => '85', 'price' => 15],
                    ['start_station_id' => 5, 'end_station_id' => 6, 'order' => 4, 'duration' => '120', 'price' => 20],
                ],
            ],
            [
                'name' => 'Upper Egypt Road',
                'stations' => [
                    ['start_station_id' => 8, 'end_station_id' => 9, 'order' => 1, 'duration' => '85', 'price' => 5],
                    ['start_station_id' => 9, 'end_station_id' => 10, 'order' => 2, 'duration' => '120', 'price' => 10],
                    ['start_station_id' => 11, 'end_station_id' => 12, 'order' => 3, 'duration' => '85', 'price' => 15],
                    ['start_station_id' => 12, 'end_station_id' => 13, 'order' => 4, 'duration' => '120', 'price' => 20],
                    ['start_station_id' => 13, 'end_station_id' => 14, 'order' => 5, 'duration' => '85', 'price' => 25],
                ],
            ],
            [
                'name' => 'Beach Egypt Road',
                'stations' => [
                    ['start_station_id' => 11, 'end_station_id' => 7, 'order' => 1, 'duration' => '85', 'price' => 5],
                    ['start_station_id' => 7, 'end_station_id' => 6, 'order' => 2, 'duration' => '120', 'price' => 10],
                    ['start_station_id' => 6, 'end_station_id' => 9, 'order' => 3, 'duration' => '85', 'price' => 15],
                    ['start_station_id' => 9, 'end_station_id' => 8, 'order' => 4, 'duration' => '120', 'price' => 20],
                    ['start_station_id' => 8, 'end_station_id' => 2, 'order' => 5, 'duration' => '85', 'price' => 25],
                ],
            ],
        ];

        foreach ($routes as $routeData) {

            $route = Route::create([
                'name' => $routeData['name'],
            ]);

            foreach ($routeData['stations'] as $routeStationData) {
                $startStationId = $routeStationData['start_station_id'];
                $endStationId = $routeStationData['end_station_id'];

                RouteStation::updateOrCreate(
                    ['route_id' => $route->id, 'start_station_id' => $startStationId, 'end_station_id' => $endStationId],
                    $routeStationData
                );
            }
        }
    }
}
