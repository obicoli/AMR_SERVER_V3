<?php

use Illuminate\Database\Seeder;
use \App\Models\Localization\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create(['code'=>'KE','name' => 'Kenya','currency'=>'Kenyan shilling','currency_sympol'=>'KES']);
        Country::create(['code'=>'AUD','name' => 'Australia','currency'=>'Australian dollar','currency_sympol'=>'AUD']);
        Country::create(['code'=>'CAD','name' => 'Canada','currency'=>'Canadian dollar','currency_sympol'=>'CAD']);
    }
}
