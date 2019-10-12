<?php

use Illuminate\Database\Seeder;

class PropertyAppliancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<5;$i++){
            for($j=1; $j<8; $j++) {
                $appliance = new \App\PropertyAppliance();
                $appliance->team_id = $i;
                $pro = \App\property::find($j);
                $appliance->property_id = $j;
                $appliance->property_value = 50;
                $appliance->property_total = 50 * $pro->ratio;
                $appliance->save();
            }
        }
    }
}
