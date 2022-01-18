<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RolesSeeder::class);
        $this->call(TranslationSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CountrySeeder::class);

        Model::reguard();
    }
}
