<?php

use Illuminate\Database\Seeder;

use App\Models\Localization\TimeZones;

class TimezoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_ = TimeZones::create(['name'=>'Africa/Addis_Ababa','label_name'=>'(GMT+03:00) Africa, Addis Ababa']);
        $time_ = TimeZones::create(['name'=>'Africa/Nairobi','label_name'=>'(GMT+03:00) Africa, Nairobi']);
        $time_ = TimeZones::create(['name'=>'Africa/Asmara','label_name'=>'(GMT+03:00) Africa, Asmara']);
        $time_ = TimeZones::create(['name'=>'Africa/Dar_es_Salaam','label_name'=>'(GMT+03:00) Africa, Dar es Salaam']);
        $time_ = TimeZones::create(['name'=>'Africa/Djibouti','label_name'=>'(GMT+03:00) Africa, Djibouti']);
        $time_ = TimeZones::create(['name'=>'Africa/Juba','label_name'=>'(GMT+03:00) Africa, Juba']);
        $time_ = TimeZones::create(['name'=>'Africa/Kampala','label_name'=>'(GMT+03:00) Africa, Kampala']);
        $time_ = TimeZones::create(['name'=>'Africa/Khartoum','label_name'=>'(GMT+03:00) Africa, Khartoum']);
        $time_ = TimeZones::create(['name'=>'Africa/Mogadishu','label_name'=>'(GMT+03:00) Africa, Mogadishu']);
        $time_ = TimeZones::create(['name'=>'Antarctica/Syowa','label_name'=>'(GMT+03:00) Antarctica, Syowa']);
        $time_ = TimeZones::create(['name'=>'Asia/Aden','label_name'=>'(GMT+03:00) Asia, Aden']);
        $time_ = TimeZones::create(['name'=>'Asia/Amman','label_name'=>'(GMT+03:00) Asia, Amman']);
        $time_ = TimeZones::create(['name'=>'Asia/Baghdad','label_name'=>'(GMT+03:00) Asia, Baghdad']);
        $time_ = TimeZones::create(['name'=>'Asia/Bahrain','label_name'=>'(GMT+03:00) Asia, Bahrain']);
        $time_ = TimeZones::create(['name'=>'Asia/Beirut','label_name'=>'(GMT+03:00) Asia, Beirut']);
        $time_ = TimeZones::create(['name'=>'Asia/Damascus','label_name'=>'(GMT+03:00) Asia, Damascus']);
        $time_ = TimeZones::create(['name'=>'Asia/Gaza','label_name'=>'(GMT+03:00) Asia, Gaza']);
        $time_ = TimeZones::create(['name'=>'Asia/Hebron','label_name'=>'(GMT+03:00) Asia, Hebron']);
        $time_ = TimeZones::create(['name'=>'Asia/Jerusalem','label_name'=>'(GMT+03:00) Asia, Jerusalem']);
        $time_ = TimeZones::create(['name'=>'Asia/Kuwait','label_name'=>'(GMT+03:00) Asia, Kuwait']);
        $time_ = TimeZones::create(['name'=>'Asia/Nicosia','label_name'=>'(GMT+03:00) Asia, Nicosia']);
        $time_ = TimeZones::create(['name'=>'Asia/Qatar','label_name'=>'(GMT+03:00) Asia, Qatar']);
        $time_ = TimeZones::create(['name'=>'Asia/Riyadh','label_name'=>'(GMT+03:00) Asia, Riyadh']);
        $time_ = TimeZones::create(['name'=>'Europe/Athens','label_name'=>'(GMT+03:00) Europe, Athens']);
        $time_ = TimeZones::create(['name'=>'Europe/Bucharest','label_name'=>'(GMT+03:00) Europe, Bucharest']);
        $time_ = TimeZones::create(['name'=>'Europe/Chisinau','label_name'=>'(GMT+03:00) Europe, Chisinau']);
        $time_ = TimeZones::create(['name'=>'Europe/Helsinki','label_name'=>'(GMT+03:00) Europe, Helsinki']);
        $time_ = TimeZones::create(['name'=>'Europe/Istanbul','label_name'=>'(GMT+03:00) Europe, Istanbul']);
        $time_ = TimeZones::create(['name'=>'Europe/Kaliningrad','label_name'=>'(GMT+03:00) Europe, Kaliningrad']);
        $time_ = TimeZones::create(['name'=>'Europe/Kiev','label_name'=>'(GMT+03:00) Europe, Kiev']);
        $time_ = TimeZones::create(['name'=>'Europe/Mariehamn','label_name'=>'(GMT+03:00) Europe, Mariehamn']);
        $time_ = TimeZones::create(['name'=>'Europe/Minsk','label_name'=>'(GMT+03:00) Europe, Minsk']);
        $time_ = TimeZones::create(['name'=>'Europe/Riga','label_name'=>'(GMT+03:00) Europe, Riga']);
        $time_ = TimeZones::create(['name'=>'Europe/Simferopol','label_name'=>'(GMT+03:00) Europe, Simferopol']);
        $time_ = TimeZones::create(['name'=>'Europe/Sofia','label_name'=>'(GMT+03:00) Europe, Sofia']);
        $time_ = TimeZones::create(['name'=>'Europe/Tallinn','label_name'=>'(GMT+03:00) Europe, Tallinn']);
        $time_ = TimeZones::create(['name'=>'Europe/Uzhgorod','label_name'=>'(GMT+03:00) Europe, Uzhgorod']);
        $time_ = TimeZones::create(['name'=>'Europe/Vilnius','label_name'=>'(GMT+03:00) Europe, Vilnius']);
        $time_ = TimeZones::create(['name'=>'Europe/Zaporozhye','label_name'=>'(GMT+03:00) Europe, Zaporozhye']);
        $time_ = TimeZones::create(['name'=>'Indian/Antananarivo','label_name'=>'(GMT+03:00) Indian, Antananarivo']);
        $time_ = TimeZones::create(['name'=>'Indian/Comoro','label_name'=>'(GMT+03:00) Indian, Comoro']);
        $time_ = TimeZones::create(['name'=>'Indian/Mayotte','label_name'=>'(GMT+03:00) Indian, Mayotte']);
    }
}
