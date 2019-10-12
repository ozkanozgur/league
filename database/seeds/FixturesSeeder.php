<?php

use Illuminate\Database\Seeder;

class FixturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // first half
        $fixture = new \App\Fixture();
        $fixture->week = 1;
        $fixture->home = 1;
        $fixture->visitor = 2;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 1;
        $fixture->home = 3;
        $fixture->visitor = 4;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 2;
        $fixture->home = 1;
        $fixture->visitor = 3;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 2;
        $fixture->home = 2;
        $fixture->visitor = 4;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 3;
        $fixture->home = 1;
        $fixture->visitor = 4;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 3;
        $fixture->home = 2;
        $fixture->visitor = 3;
        $fixture->save();

        // second half
        $fixture = new \App\Fixture();
        $fixture->week = 4;
        $fixture->home = 2;
        $fixture->visitor = 1;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 4;
        $fixture->home = 4;
        $fixture->visitor = 3;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 5;
        $fixture->home = 3;
        $fixture->visitor = 1;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 5;
        $fixture->home = 4;
        $fixture->visitor = 2;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 6;
        $fixture->home = 4;
        $fixture->visitor = 1;
        $fixture->save();

        $fixture = new \App\Fixture();
        $fixture->week = 6;
        $fixture->home = 3;
        $fixture->visitor = 2;
        $fixture->save();
    }
}
