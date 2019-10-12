<?php

use Illuminate\Database\Seeder;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pro = new \App\property();
        $pro->name = 'Kaleci';
        $pro->ratio = '15';
        $pro->save();

        $pro = new \App\property();
        $pro->name = 'Defans';
        $pro->ratio = '15';
        $pro->save();

        $pro = new \App\property();
        $pro->name = 'Orta Saha';
        $pro->ratio = '10';
        $pro->save();

        $pro = new \App\property();
        $pro->name = 'Atak';
        $pro->ratio = '30';
        $pro->save();

        $pro = new \App\property();
        $pro->name = 'Forvet';
        $pro->ratio = '15';
        $pro->save();

        $pro = new \App\property();
        $pro->name = 'Atılan Gol';
        $pro->ratio = '5';
        $pro->save();

        $pro = new \App\property();
        $pro->name = 'Yenen Gol';
        $pro->ratio = '5';
        $pro->save();
    }
}
