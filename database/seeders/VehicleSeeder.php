<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle\Vehicle;
use App\Models\Vehicle\Seat;
use App\Models\Polymorphic\Status;
use Carbon\Carbon;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'type' => 'Bus',
                'seat_count' => 12,
                'license_plate' => 'ABC123'
            ],
            [
                'type' => 'Mini Bus',
                'seat_count' => 8,
                'license_plate' => 'DEF456'
            ],
            [
                'type' => 'Microbus',
                'seat_count' => 6,
                'license_plate' => 'GHI789'
            ],
            [
                'type' => 'Car',
                'seat_count' => 4,
                'license_plate' => 'JKL012'
            ],
            [
                'type' => 'Van',
                'seat_count' => 5,
                'license_plate' => 'MNO345'
            ],
        ];

        foreach ($vehicles as $vehicleData) {
            $licensePlate = $vehicleData['license_plate'];

            $vehicle = Vehicle::updateOrCreate(['license_plate' => $licensePlate], [
                'type' => $vehicleData['type'],
                'seat_count' => $vehicleData['seat_count'],
            ]);

            if ($vehicleData['seat_count'] > 0) {
                for ($i = 1; $i <= $vehicleData['seat_count']; $i++) {
                    $seatName = $vehicle->type. '_' . $i;

                    $seat = Seat::updateOrCreate([
                        'vehicle_id' => $vehicle->id,
                        'name' => $seatName,
                    ]);

                    Status::firstOrCreate([
                        'object_type' => Seat::class,
                        'object_id' => $seat->ulid,
                        'status' => Status::AVAILABLE,
                        'content' => [
                            'history' => [
                                [
                                    'status' => Status::AVAILABLE,
                                    'timestamp' => Carbon::now(),
                                ],
                            ],
                        ],
                    ]);
                }
            }
        }

    }
}
