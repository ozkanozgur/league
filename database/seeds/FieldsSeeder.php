<?php

use Illuminate\Database\Seeder;

class FieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $field = new \App\field();
        $field->name = 'Ev sahibi gol yedi';
        $field->home_property_id = 0;
        $field->visitor_property_id = 0;
        $field->home_dice_to_go = 4;
        $field->vis_dice_to_go = 4;
        $field->save();

        $field = new \App\field();
        $field->name = 'Ev sahibi kaleci - konuk forvet';
        $field->home_property_id = 1;
        $field->visitor_property_id = 5;
        $field->home_dice_to_go = 3;
        $field->vis_dice_to_go = 1;
        $field->save();

        $field = new \App\field();
        $field->name = 'Ev sahibi defans - konuk atak';
        $field->home_property_id = 2;
        $field->visitor_property_id = 4;
        $field->home_dice_to_go = 4;
        $field->vis_dice_to_go = 2;
        $field->save();

        $field = new \App\field();
        $field->name = 'Orta saha ortak';
        $field->home_property_id = 3;
        $field->visitor_property_id = 3;
        $field->home_dice_to_go = 5;
        $field->vis_dice_to_go = 3;
        $field->save();

        $field = new \App\field();
        $field->name = 'Ev sahibi atak - konuk defans';
        $field->home_property_id = 4;
        $field->visitor_property_id = 2;
        $field->home_dice_to_go = 6;
        $field->vis_dice_to_go = 4;
        $field->save();

        $field = new \App\field();
        $field->name = 'Ev sahibi forvet - konuk kaleci';
        $field->home_property_id = 5;
        $field->visitor_property_id = 1;
        $field->home_dice_to_go = 7;
        $field->vis_dice_to_go = 5;
        $field->save();

        $field = new \App\field();
        $field->name = 'Konuk gol yedi';
        $field->home_property_id = 0;
        $field->visitor_property_id = 0;
        $field->home_dice_to_go = 4;
        $field->vis_dice_to_go = 4;
        $field->save();
    }
}
