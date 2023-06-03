<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = [
            'name' => 'Egypt',
            'code' => 'EG',
            'phonecode' => '20',
        ];

        DB::table('countries')->updateOrInsert(
            ['name' => 'Egypt'],
            $country
        );
    }
}
