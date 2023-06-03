<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $StationAdmin = [
            'platform.index'              => 1,
            'platform.systems'            => 1,
            'platform.systems.settings'   => 1,
            'platform.systems.users'      => 1,
            'platform.systems.attachment' => 1,
            'platform.systems.media'      => 1,
        ];

        Role::updateOrCreate(['slug'=> 'admin'],['name' => 'Admin','slug' => 'admin', 'permissions' => $StationAdmin]);
        Role::updateOrCreate(['slug'=> 'customer'],['name' => 'Customer', 'slug' => 'customer', 'permissions' => [] ]);
    }
}
