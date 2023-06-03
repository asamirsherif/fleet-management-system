<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Station\Station;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = [
            ['name' => 'Cairo', 'latitude' => '30.04441960', 'longitude' => '31.23571160'],
            ['name' => 'Alexandria', 'latitude' => '31.21564510', 'longitude' => '29.95526660'],
            ['name' => 'Giza', 'latitude' => '30.00807950', 'longitude' => '31.21093110'],
            ['name' => 'Port Said', 'latitude' => '31.25649980', 'longitude' => '32.28413990'],
            ['name' => 'Suez', 'latitude' => '29.97371180', 'longitude' => '32.52626750'],
            ['name' => 'Luxor', 'latitude' => '25.69893047', 'longitude' => '32.64210892'],
            ['name' => 'Aswan', 'latitude' => '24.08893800', 'longitude' => '32.89982930'],
            ['name' => 'Faiyum', 'latitude' => '29.30840060', 'longitude' => '30.84259990'],
            ['name' => 'Mansoura', 'latitude' => '31.04094890', 'longitude' => '31.37847040'],
            ['name' => 'Tanta', 'latitude' => '30.78998470', 'longitude' => '31.00152750'],
            ['name' => 'Zagazig', 'latitude' => '30.58516420', 'longitude' => '31.50465560'],
            ['name' => 'Damietta', 'latitude' => '31.41698450', 'longitude' => '31.81335030'],
            ['name' => 'Ismailia', 'latitude' => '30.60427230', 'longitude' => '32.27225040'],
            ['name' => 'Minya', 'latitude' => '28.12274395', 'longitude' => '30.74824138'],
            ['name' => 'Beni Suef', 'latitude' => '29.07707190', 'longitude' => '31.09784860'],
            ['name' => 'Sohag', 'latitude' => '26.55957940', 'longitude' => '31.69457620'],
            ['name' => 'Assiut', 'latitude' => '27.18282910', 'longitude' => '31.51668740'],
            ['name' => 'Damanhur', 'latitude' => '31.04163560', 'longitude' => '30.46915100'],
            ['name' => 'El-Mahalla El-Kubra', 'latitude' => '30.97628280', 'longitude' => '31.16475540'],
            ['name' => 'Kafr El Sheikh', 'latitude' => '31.10914070', 'longitude' => '30.93661720'],
            ['name' => 'Qena', 'latitude' => '26.15554390', 'longitude' => '32.71627200'],
        ];

        foreach ($stations as $station) {
            Station::updateOrCreate(['name' => $station['name']], [
                'latitude' => $station['latitude'],
                'longitude' => $station['longitude'],
            ]);
        }
    }
}
