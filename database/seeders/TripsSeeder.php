<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Trip\Trip;

class TripsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trips = [
            [
                'vehicle_id' => 1,
                'route_id' => 1,
                'departure_time' => Carbon::now()->addHours(1),
                'arrival_time' => Carbon::now()->addHours(3),
            ],
            [
                'vehicle_id' => 2,
                'route_id' => 2,
                'departure_time' => Carbon::now()->addHours(1),
                'arrival_time' => Carbon::now()->addHours(5),
            ],

        ];

        foreach ($trips as $tripData) {
            $trip = Trip::updateOrCreate(
                [
                    'vehicle_id' => $tripData['vehicle_id'],
                    'route_id' => $tripData['route_id'],
                ],
                [
                    'departure_time' => $tripData['departure_time'],
                    'arrival_time' => $tripData['arrival_time'],
                ]
            );
        }
    }
}
