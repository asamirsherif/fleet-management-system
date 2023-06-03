<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use App\Models\User\UserContact;
use App\Models\User\Country;
use App\Models\Polymorphic\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $user = User::updateOrCreate([
            'email' => 'admin@admin.com',
        ],
        [
            'name' => 'admin',
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'phone_number' => '01069576573'
        ]);

        if(!isset($user->status->status)){

            Status::firstOrCreate([
                'object_type' => User::class,
                'object_id' => $user->id,
                'status' => Status::ACTIVE,
                'content' => [
                    'history' => [
                        [
                            'status' => Status::ACTIVE,
                            'timestamp' => Carbon::now(),
                        ],
                    ],
                ],
            ]);

            //give superadmin role
            Artisan::call('orchid:admin --id='.$user->id);
        }

        DB::commit();
    }
}
