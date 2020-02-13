<?php

use App\Assets\Models\Machines\Vehicle\Vehicle;
use App\Models\Hospital\Hospital;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicle = Vehicle::create([
            'vhc_name'=>'ISUZU',
            'vhc_number'=>'KCB 890B',
            'vhc_id'=>'123456778899',
            'vhc_chase_number'=>'CHASE09876',
            'vhc_engine_number'=>'ENGINE09876',
        ]);
        $hospital = Hospital::find(1);
        $hospital->vehicles()->save($vehicle);
        $facility = $hospital->practices()->where('type','HQ')->get()->first();
        $facility->vehicles()->save($vehicle);
    }
}
