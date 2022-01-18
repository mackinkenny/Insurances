<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'name' => 'Riccardo Tortora',
                'email' => 'riccardo.tortora@innovass.it',
                'password' => Hash::make('123123123'),
                'phone' => '+000 000 000 000',
                'role_id' => 1,
                'login' => 'riccardo.tortora@innovass.it',
                'position' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
