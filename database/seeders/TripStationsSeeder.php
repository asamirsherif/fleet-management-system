<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transport\Route;
use Carbon\Carbon;
use App\Models\Trip\Trip;
use App\Models\Trip\TripStation;

class TripStationsSeeder extends Seeder
{
    public function run()
    {
        $subRoutes = Route::getAllSubRoutes();

        foreach ($subRoutes as $subRoute) {
            foreach($subRoute as $sub){
                $subRoutes[] = $sub;

                $tripStations = [];

                $subRoutesCount = count($subRoute);

                for ($i = 0; $i < $subRoutesCount - 1; $i++) {
                    $startStationId = $sub->start_station_id;
                    $endStationId = $sub->end_station_id;

                    $tripStations = [
                        'trip_id' => 1,
                        'start_station_id' => $startStationId,
                        'end_station_id' => $endStationId,
                        'departure_time' => Carbon::parse(Trip::find(1)->departure_time),
                        'arrival_time' => Carbon::parse(Trip::find(1)->arrival_time)->addMinutes($sub->duration),
                        'price' => $sub->price,
                    ];

                    TripStation::updateOrCreate(
                        $tripStations,
                        $tripStations
                    );
                }


            }



            // You can perform any additional operations on $tripStation if needed
        }
    }
}


