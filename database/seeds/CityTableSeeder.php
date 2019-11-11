<?php

use Illuminate\Database\Seeder;
use \App\Models\Localization\City;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //City::create(['country_code'=>'KE','name' => 'Baragoi']);
        City::create(['county_id'=>4,'name' => 'Bungoma','country_id'=>1]);
        City::create(['county_id'=>2,'name' => 'Busia','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Buruburu','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Central Business District(CBD)','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Dagoretti','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Donholm','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Eastleigh','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Embakasi','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Gigiri','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Githurai 44','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Githurai 45','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Highrise','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Imara Daima','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Industrial Area','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Jogoo Road','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Kabete','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Kahawa','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Karen','country_id'=>1]);
        City::create(['county_id'=>1,'name' => 'Kariobangi','country_id'=>1]);
//        City::create(['country_code'=>'KE','name' => 'Butere']);
//        City::create(['country_code'=>'KE','name' => 'Dadaab']);
//        City::create(['country_code'=>'KE','name' => 'Diani Beach']);
//        City::create(['country_code'=>'KE','name' => 'Eldoret']);
//        City::create(['country_code'=>'KE','name' => 'Emali']);
//        City::create(['country_code'=>'KE','name' => 'Embu']);
//        City::create(['country_code'=>'KE','name' => 'Garissa']);
//        City::create(['country_code'=>'KE','name' => 'Gede']);
//        City::create(['country_code'=>'KE','name' => 'Hola']);
//        City::create(['country_code'=>'KE','name' => 'Homa Bay']);
//        City::create(['country_code'=>'KE','name' => 'Isiolo']);
//        City::create(['country_code'=>'KE','name' => 'Kitui']);
//        City::create(['country_code'=>'KE','name' => 'Kibwezi']);
//        City::create(['country_code'=>'KE','name' => 'Kajiado']);
//        City::create(['country_code'=>'KE','name' => 'Kakamega']);
//        City::create(['country_code'=>'KE','name' => 'Kakuma']);
//        City::create(['country_code'=>'KE','name' => 'Kapenguria']);
//        City::create(['country_code'=>'KE','name' => 'Kericho']);
//        City::create(['country_code'=>'KE','name' => 'Keroka']);
//        City::create(['country_code'=>'KE','name' => 'Kiambu']);
//        City::create(['country_code'=>'KE','name' => 'Kilifi']);
//        City::create(['country_code'=>'KE','name' => 'Kisii']);
//        City::create(['country_code'=>'KE','name' => 'Kisumu']);
//        City::create(['country_code'=>'KE','name' => 'Kitale']);
//        City::create(['country_code'=>'KE','name' => 'Lamu']);
//        City::create(['country_code'=>'KE','name' => 'Langata']);
//        City::create(['country_code'=>'KE','name' => 'Litein']);
//        City::create(['country_code'=>'KE','name' => 'Lodwar']);
//        City::create(['country_code'=>'KE','name' => 'Lokichoggio']);
//        City::create(['country_code'=>'KE','name' => 'Londiani']);
//        City::create(['country_code'=>'KE','name' => 'Loyangalani']);
//        City::create(['country_code'=>'KE','name' => 'Machakos']);
//        City::create(['country_code'=>'KE','name' => 'Makindu']);
//        City::create(['country_code'=>'KE','name' => 'Malindi']);
//        City::create(['country_code'=>'KE','name' => 'Mandera']);
//        City::create(['country_code'=>'KE','name' => 'Maralal']);
//        City::create(['country_code'=>'KE','name' => 'Marsabit']);
//        City::create(['country_code'=>'KE','name' => 'Meru']);
//        City::create(['country_code'=>'KE','name' => 'Mombasa']);
//        City::create(['country_code'=>'KE','name' => 'Moyale']);
//        City::create(['country_code'=>'KE','name' => 'Mumias']);
//        City::create(['country_code'=>'KE','name' => 'Muranga']);
//        City::create(['country_code'=>'KE','name' => 'Mutomo']);
//        City::create(['country_code'=>'KE','name' => 'Nairobi']);
//        City::create(['country_code'=>'KE','name' => 'Naivasha']);
//        City::create(['country_code'=>'KE','name' => 'Nakuru']);
//        City::create(['country_code'=>'KE','name' => 'Namanga']);
//        City::create(['country_code'=>'KE','name' => 'Nanyuki']);
//        City::create(['country_code'=>'KE','name' => 'Naro Moru']);
//        City::create(['country_code'=>'KE','name' => 'Narok']);
//        City::create(['country_code'=>'KE','name' => 'Nyahururu']);
//        City::create(['country_code'=>'KE','name' => 'Nyeri']);
//        City::create(['country_code'=>'KE','name' => 'Ruiru']);
//        City::create(['country_code'=>'KE','name' => 'Shimoni']);
//        City::create(['country_code'=>'KE','name' => 'Takaungu']);
//        City::create(['country_code'=>'KE','name' => 'Thika']);
//        City::create(['country_code'=>'KE','name' => 'Vihiga']);
//        City::create(['country_code'=>'KE','name' => 'Voi']);
//        City::create(['country_code'=>'KE','name' => 'Wajir']);
//        City::create(['country_code'=>'KE','name' => 'Watamu']);
//        City::create(['country_code'=>'KE','name' => 'Webuye']);
//        City::create(['country_code'=>'KE','name' => 'Wote']);
//        City::create(['country_code'=>'KE','name' => 'Wundanyi']);
    }
}
