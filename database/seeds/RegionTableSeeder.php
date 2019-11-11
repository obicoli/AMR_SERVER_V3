<?php

use Illuminate\Database\Seeder;
use \App\Models\Localization\Region;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::create(['name'=>'Nairobi','country_id'=>1]);
        Region::create(['name'=>'Nyanza','country_id'=>1]);
        Region::create(['name'=>'Western','country_id'=>1]);
        Region::create(['name'=>'Central','country_id'=>1]);
        Region::create(['name'=>'Coast','country_id'=>1]);
        Region::create(['name'=>'North Eastern','country_id'=>1]);
        Region::create(['name'=>'Rift Valley','country_id'=>1]);
    }
}
