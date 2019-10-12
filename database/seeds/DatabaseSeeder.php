<?php

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
        $this->call(TeamsSeeder::class);
        $this->call(PropertiesSeeder::class);
        $this->call(PropertyAppliancesSeeder::class);
        $this->call(FixturesSeeder::class);
        $this->call(FieldsSeeder::class);
    }
}
