<?php

use Illuminate\Database\Seeder;
use \App\Models\Localization\County;

class CountyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        County::create(['name'=>'Nairobi','region_id'=>1]);
        County::create(['name'=>'Busia','region_id'=>3]);
        County::create(['name'=>'Kakamega','region_id'=>3]);
        County::create(['name'=>'Bungoma','region_id'=>3]);
        County::create(['name'=>'Vihiga','region_id'=>3]);
    }
}
