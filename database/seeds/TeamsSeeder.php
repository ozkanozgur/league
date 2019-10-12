<?php

use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = new \App\Team();
        $team->name = 'Liverpool';

        $team->points = 0;
        $team->played = 0;
        $team->won = 0;
        $team->drawn = 0;
        $team->lost = 0;
        $team->save();

        $team = new \App\Team();
        $team->name = 'Manchester City';

        $team->points = 0;
        $team->played = 0;
        $team->won = 0;
        $team->drawn = 0;
        $team->lost = 0;
        $team->save();

        $team = new \App\Team();
        $team->name = 'Arsenal';

        $team->points = 0;
        $team->played = 0;
        $team->won = 0;
        $team->drawn = 0;
        $team->lost = 0;
        $team->save();

        $team = new \App\Team();
        $team->name = 'Chelsea';

        $team->points = 0;
        $team->played = 0;
        $team->won = 0;
        $team->drawn = 0;
        $team->lost = 0;
        $team->save();
    }
}
